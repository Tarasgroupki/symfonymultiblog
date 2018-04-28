<?php

namespace Acme\Bundle\ImageGalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Acme\Bundle\ImageGalleryBundle\Entity\Images;
use Acme\Bundle\ImageGalleryBundle\Entity\Main_Img;
use Acme\Bundle\ImageGalleryBundle\Form\ImagesType;

class DefaultController extends Controller
{
    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, name="image_index")
     */
    public function indexAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('AcmeImageGalleryBundle:Images')->findByProductId($id);
        $img = array();
        foreach($images as $key => $image):
            $img[$key]['id'] = $image->getId();
           $img[$key]['img_url'] = $image->getImgUrl();
        $img[$key]['description'] = $image->getDescription();
        $img[$key]['active'] = false;
        endforeach;
        $js_array = json_encode($img);
         $imags = new Images;
         $form = $this->createForm(ImagesType::class,$imags);
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
             $uploadedFile = $imags->getImags();
        // print_r($uploadedFile);die;
         if($uploadedFile) {
             $fileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
             echo $fileName;
             //die;
             $imags->setProductId($id);
             $imags->setImgUrl('/symfony/web/images/Gallery'.$id.'/'. $fileName);
             $imags->getImags()->move('X:\home/symfony.ua/www/symfony/web/images/Gallery'.$id.'/', $fileName);
             $em->persist($imags);
             $em->flush();
         }
         }
        return $this->render('AcmeImageGalleryBundle:Default:index.html.twig',['form' => $form->createView(),'id'=>$id,'images' => $images,'js_array' => $js_array]);
    }

    /**
     * @Route("/delete", name="delete_images")

     */
  public function deleteAction(Request $request)
  {//print_r($request->get('id'));die;
      $em = $this->getDoctrine()->getManager();
     // $query = 'Update ``';
      if($request->get('id')){
          foreach($request->get('id') as $key => $value):
              if($value != null):
              $ids[$key] = $value;
              endif;
          endforeach;
          //print_r($ids);die;
          $qb = $em->createQueryBuilder();
          $qb->delete('AcmeImageGalleryBundle:Images','b')
              ->add('where', $qb->expr()->in('b.id', "?1"));
          $qb->setParameter(1,$ids)->getQuery()->execute();
          echo 'Видалено!';
      }
      else
      {
          echo 'Нічого не вибрано';
      }
      return $this->render('AcmeImageGalleryBundle:Default:add.html.twig',[]);
  }
    /**
     * @Route("/main", name="main_images")
     */
  public function mainAction(Request $request)
  {//print_r($request->get('id'));die;
      $em = $this->getDoctrine()->getManager();
      $images = $em->getRepository('AcmeImageGalleryBundle:Main_Img')->findByProductId($request->get('product_id'));
      if($request->get('id')):
      foreach($request->get('id') as $key => $value):
          if($value != null):
              $ids = $value;
          endif;
      endforeach;

      if($images):
          $query = $em->createQueryBuilder()->update('AcmeImageGalleryBundle:Main_Img', 'c')
              ->set('c.imgId', ':img_id')
              ->where('c.productId = :id')
              ->setParameter('img_id', $ids)
              ->setParameter('id', $request->get('product_id'))
              ->getQuery();
          $query->execute();
      else://echo $ids;die;
          $em->getConnection()->insert('main_img',['product_id' => $request->get('product_id'),'img_id' => $ids]);
     // $main_img = new Main_Img();
     // $main_img->setProductId($request->get('product_id'));
     // $main_img->setImgId($ids);
      //$main_img->setMainImg($ids);
      //echo $main_img->getImgId();die;
     // var_dump($main_img)die;
     // $em->persist($main_img);
    //  $em->flush();
      endif;
      endif;
      $referer = $request->headers->get('referer');
      return $this->redirect($referer);

  }

}
