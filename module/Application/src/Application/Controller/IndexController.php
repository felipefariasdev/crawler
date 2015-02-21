<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Model\Services\Crawler;


class IndexController extends AbstractActionController
{

    /** @return Crawler */
    private function getCrawler(){
        return $this->getServiceLocator()->get('Crawler');
    }

    public function indexAction()
    {

        $this->getCrawler()->start();

        $urls = $this->getCrawler()->getUrls();

        foreach($urls as $vUrl){
            $this->getCrawler()->crawler($vUrl['url'],'/<a href=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?>/i');
        }

        return new ViewModel();
    }
}
