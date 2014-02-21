<?php

namespace Tcx\Bundle\TcxAccountBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tcx\Bundle\TcxAccountBundle\Entity\TcxAccount;
use Tcx\Bundle\TcxAccountBundle\Form\TcxAccountType;

/**
 * TcxAccount controller.
 *
 * @Route("/tcxaccount")
 */
class TcxAccountController extends Controller
{

    /**
     * Lists all TcxAccount entities.
     *
     * @Route("/", name="tcxaccount")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TcxAccountBundle:TcxAccount')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TcxAccount entity.
     *
     * @Route("/", name="tcxaccount_new")
     * @Method("POST")
     * @Template("TcxAccountBundle:TcxAccount:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TcxAccount();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $entity->upload();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tcxaccount_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a TcxAccount entity.
    *
    * @param TcxAccount $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TcxAccount $entity)
    {
        $form = $this->createForm(new TcxAccountType(), $entity, array(
            'action' => $this->generateUrl('tcxaccount'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TcxAccount entity.
     *
     * @Route("/new", name="tcxaccount_create")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TcxAccount();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TcxAccount entity.
     *
     * @Route("/{id}", name="tcxaccount_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TcxAccountBundle:TcxAccount')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TcxAccount entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TcxAccount entity.
     *
     * @Route("/{id}/edit", name="tcxaccount_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TcxAccountBundle:TcxAccount')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TcxAccount entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a TcxAccount entity.
    *
    * @param TcxAccount $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TcxAccount $entity)
    {
        $form = $this->createForm(new TcxAccountType(), $entity, array(
            'action' => $this->generateUrl('tcxaccount_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TcxAccount entity.
     *
     * @Route("/{id}", name="tcxaccount_update")
     * @Method("PUT")
     * @Template("TcxAccountBundle:TcxAccount:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TcxAccountBundle:TcxAccount')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TcxAccount entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tcxaccount_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TcxAccount entity.
     *
     * @Route("/{id}", name="tcxaccount_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TcxAccountBundle:TcxAccount')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TcxAccount entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tcxaccount'));
    }

    /**
     * Creates a form to delete a TcxAccount entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tcxaccount_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
