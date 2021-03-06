<?php

namespace Gnal\Bundle\CoreBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gnal\Bundle\AnnBundle\Entity\Network;

class CoreController extends ContainerAware
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $nm = $this->container->get('gnal_ann.network_manager');

        $network = $nm->findOneBy(array('id' => 1));



        return array('networks' => $nm->findAll());
    }

    /**
     * @Route("/train/{id}/")
     * @Template()
     */
    public function trainAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $network = $em->getRepository('GnalAnnBundle:Network')->findOneBy(array('id' => $id));

        $trainingSets[0] = array('input' => array(1, 0, 0, 0), 'targets' => array(1, 0, 0, 0));
        $trainingSets[1] = array('input' => array(0, 1, 0, 0), 'targets' => array(0, 1, 0, 0));
        $trainingSets[2] = array('input' => array(0, 0, 1, 0), 'targets' => array(0, 0, 1, 0));
        $trainingSets[3] = array('input' => array(0, 0, 0, 1), 'targets' => array(0, 0, 0, 1));

        $start = microtime(true);
        for ($i=0; $i < 1; $i++) {
            $network->train($trainingSets[mt_rand(0, 3)]);
        }
        $exectime = microtime(true) - $start;

        $em->persist($network);
        $em->flush();

        $input = $network->getInputs();
        $outputs = $network->getOutputs();
        echo 'Age: '.$network->getAge().' epochs.<br>';
        echo 'Input: ';
        echo $input[0].' '.$input[1].' '.$input[2].' '.$input[3];
        echo '<br>';
        echo 'Output: ';
        echo round($outputs[0]).' '.round($outputs[1]).' '.round($outputs[2]).' '.round($outputs[3]);
        echo '<br>';
        echo 'Exec time: '.$exectime.'<br>';
        // $success = $network->getSuccess();
        // $failure = $network->getFailure();
        // echo 'Successes: '.$success.' / 1000<br>';
        // echo 'Failures: '.$failure.' / 1000';

        return new Response();
    }

    /**
     * @Route("/run/{id}/")
     * @Template()
     */
    public function runAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $network = $em->getRepository('GnalAnnBundle:Network')->findOneBy(array('id' => $id));

        $trainingSets[0] = array('input' => array(1, 1, 1), 'targets' => array(1, 1, 1));
        $trainingSets[1] = array('input' => array(0, 1, 0), 'targets' => array(0, 1, 0));
        $trainingSets[2] = array('input' => array(1, 0, 0), 'targets' => array(1, 0, 0));
        $trainingSets[3] = array('input' => array(0, 1, 1), 'targets' => array(0, 1, 1));
        $trainingSets[4] = array('input' => array(0, 0, 1), 'targets' => array(0, 0, 1));
        $trainingSets[5] = array('input' => array(1, 0, 1), 'targets' => array(1, 0, 1));
        $trainingSets[6] = array('input' => array(1, 1, 0), 'targets' => array(1, 1, 0));
        $trainingSets[7] = array('input' => array(0, 0, 0), 'targets' => array(0, 0, 0));

        $start = microtime(true);

        $network->run($trainingSets[mt_rand(0, 7)]['input']);

        $exectime = microtime(true) - $start;

        $input = $network->getInputs();
        $outputs = $network->getOutputs();
        echo 'Age: '.$network->getAge().' epochs.<br>';
        echo 'Input: ';
        echo $input[0].' '.$input[1].' '.$input[2];
        echo '<br>';
        echo 'Output: ';
        echo round($outputs[0]).' '.round($outputs[1]).' '.round($outputs[2]);
        echo '<br>';
        echo 'Exec time: '.$exectime.'<br>';
        // $success = $network->getSuccess();
        // $failure = $network->getFailure();
        // echo 'Successes: '.$success.' / 1000<br>';
        // echo 'Failures: '.$failure.' / 1000';

        return new Response();
    }
}
