<?php

namespace Acme\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Acme\ApiBundle\Exception\InvalidFormException;
use Acme\ApiBundle\Form\HardwareType;
use Acme\ApiBundle\Model\HardwareInterface;

class HardwareController extends FOSRestController
{
    /**
     * Get single Hardware,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Hardware for a given id",
     *   output = "Acme\ApiBundle\Entity\Hardware",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="hardware")
     *
     * @param Request $request the request object
     * @param int     $id      the hardware id
     *
     * @return array
     *
     * @throws NotFoundHttpException when hardware not exist
     */
    public function getHardwareAction($id)
    {
        $hardware = $this->getOr404($id);

        return $hardware;
    }

    /**
     * Fetch a Hardware or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return HardwareInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($hardware = $this->container->get('acme_api.hardware.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }
        return $hardware;
    }

    /**
     * Create a Hardware from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new hardware from the submitted data.",
     *   input = "Acme\ApiBundle\Form\HardwareType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AcmeApiBundle:Hardware:newHardware.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postHardwareAction(Request $request)
    {
        try {
            $newHardware = $this->container->get('acme_api.hardware.handler')->post(
                $request->request->all()
            );
            $routeOptions = array(
                'id' => $newHardware->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_hardware', $routeOptions, Codes::HTTP_CREATED);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Presents the form to use to create a new hardware.
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
    public function newHardwareAction()
    {
        return $this->createForm(new HardwareType());
    }

    /**
     * Update existing hardware from the submitted data or create a new hardware at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Acme\ApiBundle\Form\HardwareType",
     *   statusCodes = {
     *     201 = "Returned when the Hardware is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AcmeApiBundle:Hardware:editCategory.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the hardware id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function putHardwareAction(Request $request, $id)
    {
        try {
            if (!($hardware = $this->container->get('acme_api.hardware.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $hardware = $this->container->get('acme_api.hardware.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $hardware = $this->container->get('acme_api.hardware.handler')->put(
                    $hardware,
                    $request->request->all()
                );
            }
            $routeOptions = array(
                'id' => $hardware->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_hardware', $routeOptions, $statusCode);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update existing hardware from the submitted data or create a new hardware at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Acme\ApiBundle\Form\HardwareType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AcmeApiBundle:Hardware:editHardware.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the hardware id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function patchHardwareAction(Request $request, $id)
    {
        try {
            $hardware = $this->container->get('acme_api.hardware.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );
            $routeOptions = array(
                'id' => $hardware->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_hardware', $routeOptions, Codes::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Delete single Hardware,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Delete a Hardware for a given id",
     *   output = "array",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="hardware")
     *
     * @param Request $request the request object
     * @param int     $id      the hardware id
     *
     * @return array
     *
     * @throws NotFoundHttpException when category not exist
     */
    public function deleteHardwareAction($id)
    {
        $hardware = $this->getOr404($id); //if no category throw exception
        $this->container->get('acme_api.hardware.handler')->delete($id);
        return $hardware;
    }

    /**
     * List all hardwares.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     * @Annotations\QueryParam(name="category", requirements="\d+", nullable=true, description="Get by category ID")
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing hardwares.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many hardwares to return. Use 0 to list all.")
     * @Annotations\QueryParam(name="available", requirements="true|false", nullable=true, description="List available or not available hardware")
     *
     * @Annotations\View(
     *  templateVar="hardwares"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getHardwaresAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        $available = $paramFetcher->get('available');
        $category = $paramFetcher->get('category');

        if($category !== null){
            if (!$this->container->get('acme_api.category.handler')->get($category)) {
                throw new NotFoundHttpException(sprintf('The category resource \'%s\' was not found.',$category));
            }
        }

        $result = $this->container->get('acme_api.hardware.handler')->all($limit, $offset, $available, $category);
        if(count($result) <= 0){
            throw new NotFoundHttpException(sprintf('No hardware'));
        }
        return $result;
    }
}
