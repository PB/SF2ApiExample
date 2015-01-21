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
use Acme\ApiBundle\Exception\InvalidFormException;
use Acme\ApiBundle\Form\CategoryType;
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

    /**
     * Create a Category from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new category from the submitted data.",
     *   input = "Acme\ApiBundle\Form\CategoryType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AcmeApiBundle:Category:newCategory.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postCategoryAction(Request $request)
    {
        try {
            $newCategory = $this->container->get('acme_api.category.handler')->post(
                $request->request->all()
            );
            $routeOptions = array(
                'id' => $newCategory->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_category', $routeOptions, Codes::HTTP_CREATED);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Presents the form to use to create a new category.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newCategoryAction()
    {
        return $this->createForm(new CategoryType());
    }

    /**
     * Update existing category from the submitted data or create a new category at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Acme\ApiBundle\Form\CategoryType",
     *   statusCodes = {
     *     201 = "Returned when the Category is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AcmeApiBundle:Category:editCategory.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the category id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function putCategoryAction(Request $request, $id)
    {
        try {
            if (!($category = $this->container->get('acme_api.category.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $category = $this->container->get('acme_api.category.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $category = $this->container->get('acme_api.category.handler')->put(
                    $category,
                    $request->request->all()
                );
            }
            $routeOptions = array(
                'id' => $category->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_category', $routeOptions, $statusCode);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }
    /**
     * Update existing category from the submitted data or create a new category at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Acme\ApiBundle\Form\CategoryType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AcmeApiBundle:Category:editCategory.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the category id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function patchCategoryAction(Request $request, $id)
    {
        try {
            $category = $this->container->get('acme_api.category.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );
            $routeOptions = array(
                'id' => $category->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_category', $routeOptions, Codes::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Delete single Category,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Delete a Category for a given id",
     *   output = "array",
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
    public function deleteCategoryAction($id)
    {
        $category = $this->getOr404($id); //if no category throw exception
        $this->container->get('acme_api.category.handler')->delete($id);
        return $category;
    }

    /**
     * List all categories.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing categories.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many categories to return.")
     *
     * @Annotations\View(
     *  templateVar="categories"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getCategoriesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        return $this->container->get('acme_api.category.handler')->all($limit, $offset);
    }
}
