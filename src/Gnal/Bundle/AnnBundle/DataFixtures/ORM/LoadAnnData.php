<?php

namespace Gnal\Bundle\AnnBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Gnal\Bundle\AnnBundle\Entity\Network;

class LoadAnnData extends AbstractFixture
{
    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $network = new Network(array(3, 3, 1));
        $network->setLearningRate(0.5);
        $network->setName('MLP');
        $this->save($network);
    }

    protected function save($e)
    {
        $this->manager->persist($e);
        $this->manager->flush();
    }
}
