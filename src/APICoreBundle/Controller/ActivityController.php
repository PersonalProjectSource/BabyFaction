<?php

namespace APICoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use APICoreBundle\Entity\Activity;
use APICoreBundle\Form\ActivityType;

/**
 * Activity controller.
 *
 * @Route("/activity")
 */
class ActivityController extends Controller
{

    /**
     * Lists all Activity entities.
     *
     * @Route("/", name="activity")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('APICoreBundle:Activity')->findAll();
        $type = "json";

        header('Access-Control-Allow-Origin: *');
//        header('Access-Control-Allow-Methods: "POST, PUT, GET, OPTIONS, DELETE"');
//        header('Access-Control-Allow-Headers: "x-requested-with"');
//        header('Access-Control-Max-Age: "3600"');

        return $this->render('APICoreBundle:'.$type.':Activity/index.'.$type.'.twig', [
            'entities' => $entities
        ]);
    }

    /**
     * Creates a new Activity entity.
     *
     * @Route("/", name="activity_create")
     * @Method("POST")
     * @Template("APICoreBundle:Activity:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Activity();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('activity_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Activity entity.
     *
     * @param Activity $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Activity $entity)
    {
        $form = $this->createForm(new ActivityType(), $entity, array(
            'action' => $this->generateUrl('activity_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Activity entity.
     *
     * @Route("/new", name="activity_new")
     * @Method("GET|POST")
     * @Template()
     */
    public function newAction(Request $request)
    {
        dump($request);die;


    }

    /**
     * Finds and displays a Activity entity.
     *
     * @Route("/{id}", name="activity_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('APICoreBundle:Activity')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Activity entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $type = "html";

        return $this->render('APICoreBundle:'.$type.':Activity/show.'.$type.'.twig', [
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Activity entity.
     *
     * @Route("/{id}/edit", name="activity_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('APICoreBundle:Activity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Activity entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $type = "html";

        return $this->render('APICoreBundle:'.$type.':Activity/edit.'.$type.'.twig', [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
    * Creates a form to edit a Activity entity.
    *
    * @param Activity $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Activity $entity)
    {
        $form = $this->createForm(new ActivityType(), $entity, array(
            'action' => $this->generateUrl('activity_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Activity entity.
     *
     * @Route("/{id}", name="activity_update")
     * @Method("PUT")
     * @Template("APICoreBundle:Activity:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('APICoreBundle:Activity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Activity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('activity_edit', array('id' => $id)));
        }

        $type = "html";
        return $this->render('APICoreBundle:'.$type.':Activity/show.'.$type.'.twig', [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }
    /**
     * Deletes a Activity entity.
     *
     * @Route("/{id}", name="activity_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('APICoreBundle:Activity')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Activity entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('activity'));
    }

    /**
     * Creates a form to delete a Activity entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('activity_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
