<?php

namespace Acme\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use Acme\ApiBundle\Exception\InvalidFormException;
//use Acme\ApiBundle\Form\PageType;
use Acme\ApiBundle\Model\CategoryInterface;


class CategoryController extends FOSRestController
{
    /**
     * Get single Category,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Category for a given id",
     *   output = "Acme\ApiBundle\Entity\Category",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="category")
     *
     * @param Request $request the request object
     * @param int     $id      the category id
     *
     * @return array
     *
     * @throws NotFoundHttpException when category not exist
     */
    public function getCategoryAction($id)
    {
        $category = $this->getOr404($id);

        return $category;
    }

    /**
     * Fetch a Category or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return CategoryInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($category = $this->container->get('acme_api.category.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }
        return $category;
    }
}
