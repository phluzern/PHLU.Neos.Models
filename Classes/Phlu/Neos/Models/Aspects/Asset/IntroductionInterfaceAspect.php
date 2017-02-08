<?php
namespace Phlu\Neos\Models\Aspects\Asset;

/*
 * This file is part of the Neos.Neos package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Phlu\Qmpilot\Domain\Model\Qmpilot;

/**
 * @Flow\Introduce("class(Neos\Media\Domain\Model\Asset)", interfaceName="Phlu\Neos\Models\Aspects\Asset\AssetInterface")
 * @Flow\Aspect
 */
class IntroductionInterfaceAspect
{


    /**
     * Around advice, implements the new method "getQmpilot" of the AssetInterface     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->getHidden())")
     */
    public function getHidden(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {

        return $joinPoint->getProxy()->hidden;
    }


    /**
     * Around advice, implements the new method "setHidden" of the
     * "AssetInterface" interface
     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->setHidden())")
     */
    public function setHidden(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {

        $joinPoint->getProxy()->hidden = $joinPoint->getMethodArgument('hidden') ? 1 : 0;

    }


    /**
     * Around advice, implements the new method "getQmpilot" of the AssetInterface     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->getSearchIndex())")
     */
    public function getSearchIndex(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {

        return $joinPoint->getProxy()->searchIndex;
    }


    /**
     * Around advice, implements the new method "setSearchIndex" of the
     * "AssetInterface" interface
     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->setSearchIndex())")
     */
    public function setSearchIndex(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {

        $joinPoint->getProxy()->searchIndex = $joinPoint->getMethodArgument('searchIndex');

    }


    /**
     * Around advice, implements the new method "getQmpilot" of the AssetInterface     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->getKeywords())")
     */
    public function getKeywords(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {

        return $joinPoint->getProxy()->keywords;
    }


    /**
     * Around advice, implements the new method "setKeywords" of the
     * "AssetInterface" interface
     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->setKeywords())")
     */
    public function setKeywords(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {

        $joinPoint->getProxy()->keywords = $joinPoint->getMethodArgument('keywords') ? 1 : 0;

    }


    /**
     * Around advice, implements the new method "getMediaTypeShortname" of the
     * "AssetInterface" interface
     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->getMediaTypeShortname())")
     */
    public function getMediaTypeShortname(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {


        return $this->getMediaTypePrintable($joinPoint->getProxy()->getResource()->getMediaType());


    }

    /**
     * Around advice, implements the new method "getFileDescription" of the
     * "AssetInterface" interface
     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->getFileDescription())")
     */
    public function getFileDescription(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {


        $bytes = $joinPoint->getProxy()->getResource()->getFileSize();
        $decimals = 1;

        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);

        $fileType = $this->getMediaTypePrintable($joinPoint->getProxy()->getResource()->getMediaType(), true);

        if ($fileType == 'internal') {
            return '';
        }


        if ($fileType == 'Link') {

            $uri = parse_url($joinPoint->getProxy()->getResource()->getLink());
            return isset($uri['host']) ? $uri['host'] : $joinPoint->getProxy()->getResource()->getLink();

        }

        return $this->getMediaTypePrintable($joinPoint->getProxy()->getResource()->getMediaType(), true) . ', ' . sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];


    }


    /**
     * Around advice, implements the new method "getTarget" of the
     * "AssetInterface" interface
     *
     * @param  \Neos\Flow\Aop\JoinPointInterface $joinPoint The current join point
     * @return void
     * @Flow\Around("method(Neos\Media\Domain\Model\Asset->getTarget())")
     */
    public function getTarget(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {

        $fileType = $this->getMediaTypePrintable($joinPoint->getProxy()->getResource()->getMediaType());

        if ($fileType == 'shortcut') {
            return $this->getMediaTypePrintable($joinPoint->getProxy()->getResource()->getSha1());
        }

       if ($fileType == 'internal') {
            return "_self";
        }


        return $fileType;



    }

    /**
     * Helper function to generate media type strings
     *
     */

    private function getMediaTypePrintable($mediaType, $humanredable = false)
    {



        if ($mediaType == 'node/html') {
            return 'internal';
        }

        $fileType = '';

        $exp = explode("/", $mediaType, 2);
        $fileType = $exp[count($exp) - 1];


        if (strtolower($fileType) == 'msword') {
            $fileType = 'word';
        }

        else if (substr_count($fileType,'shortcut')) {
            $fileType = 'shortcut';
        }

        else if (substr_count($fileType, 'octet-stream')) {
            $fileType = 'shortcut';
        }

        else if (substr_count($fileType, 'officedocument.spreadsheetml')) {
            $fileType = 'excel';
        }

        else if (substr_count($fileType, 'officedocument.wordprocessingml')) {
            $fileType = 'word';
        }

        else if (substr_count($fileType, 'ms-excel')) {
            $fileType = 'excel';
        }

        else if (substr_count($fileType, 'ms-word')) {
            $fileType = 'word';
        }



        $fileType = strtolower($fileType);

        if ($humanredable) {

            switch ($fileType) {

                case 'shortcut':
                    return 'Link';
                    break;

                case 'word':
                    return 'Word';
                    break;

                case 'excel':
                    return 'Excel';
                    break;

                case 'pdf':
                    return 'PDF';
                    break;

                case 'jpeg':
                case 'jpg':
                case 'png':
                case 'gif':
                    return 'Bild';
                    break;

                default:
                    return $fileType;
                    break;
            }


        }

        return $fileType;


    }


}
