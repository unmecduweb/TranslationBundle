<?php

namespace MWEB\TranslationBundle\Tests\Functional\TestBundle\Controller;

use JMS\DiExtraBundle\Annotation as DI;
use LI\SecurityExtraBundle\Annotation\PreAuthorize;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/apples")
 * @author Johannes
 */
class AppleController
{
    /**
     * @Route("/view")
     * @Template
     */
    public function viewAction()
    {
        return array('nbApples' => 5);
    }
}