<?php

namespace Acme\BlogBundle\Controller;

use Acme\Bundle\UserBundle\Entity\Roles;
use Acme\BlogBundle\Entity\Language;
use Acme\BlogBundle\Entity\Blog;
use Acme\BlogBundle\Entity\Comment;
use Acme\BlogBundle\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authentication\Token\RememberMeToken;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DefaultController extends Controller
{
    public function indexAction(Request $request,$page = 1)
    {
		$locale = $request->getLocale();
		$em = $this->getDoctrine()->getManager();

		//var_dump($images[0]->getImages()->getImgUrl());die;

      // print_r($img);die;
        $categories = $em->getRepository('BlogBundle:Category')->findByLocale($locale);
		//$menuItems = $this->getMenuItems($categories);
		//echo '<pre>'.print_r($menuItems,true).'</pre>';die;
		$languages = $this->get('my_widget')->getLanguages();
		$avatar = $this->get('my_widget')->getProfile();
		if(!$request->get('id'))
		{
		    $images = $em->getRepository('AcmeImageGalleryBundle:Main_Img')->findAll();
		   // $blogs = $em->getRepository('BlogBundle:Blog')->findByLocale($locale);
            $query = $em->createQueryBuilder('p')->select('a')->from('BlogBundle:Blog', 'a')
                ->join('AcmeImageGalleryBundle:Images','im','with','im.productId = a.productId')->where('a.locale = :locale')
                ->setParameter('locale',$locale)->getQuery();
            $blogs = $this->paginate($query,$page);
            //print_r($blogs->getImages());die;

        }
		else
		{
			$cts = $em->getRepository('BlogBundle:Category')->findByParentId($request->get('id'));
			//$blogs = $em->getRepository('BlogBundle:Blog')->findBy(['locale' => $locale , 'categoryId' => $request->get('id')]);
			$query = $em->createQueryBuilder('p')->select('a')->from('BlogBundle:Blog','a')->where('a.locale = :locale')
                ->andwhere('a.categoryId = :cat_id')->setParameter('locale',$locale)->setParameter('cat_id',$request->get('id'))->getQuery();
			$blogs = $this->paginate($query,$page);
			$maxPages = 5;
			$thisPage = $page;
            foreach($cts as $key => $cats):
		    $blog_edit = $em->getRepository('BlogBundle:Blog')->findBy(['locale' => $locale , 'categoryId' => $cats->getCategoryId()]);
			if(!empty($blogs) && !empty($blog_edit)):
			$blogs[count($blogs) - 1 + $key] = $blog_edit[$key];
			endif;
			endforeach;
			foreach($blogs as $key => $value):
                $ids[$key] = $value->getProductId();
            endforeach;
			$images = $em->getRepository('AcmeImageGalleryBundle:Main_Img')->findByProductId($ids);
		}
        $maxPages = ceil($blogs->count() / 5);
		foreach($images as $key => $image):
        $img[$image->getProductId()] = $image->getImages()->getImgUrl();
    endforeach;
		return $this->render('BlogBundle:Default:index.html.twig',array('blogs' => $blogs,'languages' => $languages,'categories' => $categories,'avatar' => $avatar,'images' => $img,'maxPages' => $maxPages,'thisPage' => $page)
		);
    }
	public function numberAction($id)
	{
		//$post = $this->getDoctrine()->getRepository('AcmeBlogBundle:Blog')->find($id);
		return $this->render('BlogBundle:Default:number.html.twig',
		[
		  'id' => $id,
		  //'post' => $post
		]
		);
	}
	/**
     * Creates a new blog entity.
     *
     * @Route("/authorize", name="blog_authorize")
     * @Method({"GET", "POST"})
     */
	public function authorizeAction(Request $request)
	{//die;
		$em = $this->getDoctrine()->getManager();
		$params = $em->getRepository('AcmeUserBundle:Roles')->findByUserId($this->getUser()->getId());
		foreach($params as $key => $value)
		{
			$roles[$key] = $value->getItemName();
		}
		if(isset($roles)):
		$this->getUser()->setRoles($roles);
		endif;
		$user = $this->getUser();
		$token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
        $key = $this->getParameter('secret'); // your security key from parameters.yml

        $token = new RememberMeToken($user, 'main', $key);
		$this->get('security.token_storage')->setToken($token);
      //  $this->get('security.authorization_checker')->setToken($token);
	   // If the firewall name is not main, then the set value would be instead:
        // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
        $this->get('session')->set('_security_main', serialize($token));

        // Fire the login event manually
        $event = new InteractiveLoginEvent($request, $token);
        //print_r($event);die;
	    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
	$referer = $request->headers->get('referer');
	//print_r($referer->headers());die;
	return $this->redirect('/symfony/web/app_dev.php/en');
	}
	 public function showAction(Blog $blog,Request $request)
    {
		$id = $blog->getProductId();
		$locale = $request->getLocale();
		$em = $this->getDoctrine()->getManager();
		$images = $em->getRepository('AcmeImageGalleryBundle:Images')->findByProductId($id);
		//print_r($images);die;
        $languages = $this->get('my_widget')->getLanguages();
		$avatar = $this->get('my_widget')->getProfile();
		$comment = new Comment();
		$comments = $em->getRepository('BlogBundle:Comment')->findByPostId($blog->getProductId());
		//print_r($comments);die;
		$blog = $em->getRepository('BlogBundle:Blog')->findBy(
		array('productId'=> $id,'locale' => $locale)
		)[0];
		$form = $this->createForm(CommentType::class, $comment);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$comment->setUsername($this->getUser()->getUsername());
			$comment->setPostId($blog->getProductId());
			$em->persist($comment);
			$em->flush();
		}
		//print_r($comments);die;
		return $this->render('BlogBundle:Default:show.html.twig', array(
            'languages' => $languages,
			'blog' => $blog,
			'images' => $images,
			'avatar' => $avatar,
			'comments' => (isset($comments)) ? $comments : null,
            'form' => $form->createView(),
		));
    }
	public function updateAction(Request $request)
	{
		$qb = $this->getDoctrine()->getManager();
		$query = $qb->createQueryBuilder()->update('BlogBundle:Comment', 'c')
        ->set('c.title', ':title')
		->set('c.text', ':text')
        ->where('c.id = :id')
        ->setParameter('title', $request->get('title'))
		->setParameter('text', $request->get('text'))
		->setParameter('id', $request->get('id'))
        ->getQuery();
		$query->execute();
		$referer = $request->headers->get('referer');
        return $this->redirect($referer);
		
	}
	public function deleteAction(Request $request)
    {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $qb->delete('BlogBundle:Comment','b')
            ->where('b.id = :id');
            $qb->setParameter('id',$request->get('id'))->getQuery()->execute();
            $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
	public function helloAction()
	{
		return $this->render('BlogBundle:Default:hello.html.twig');
	}
	private function getMenuItems($categories)
    {
        $categoryTree = [];
foreach ($categories as $category) {
    $parentId = $category->getParentId() ? (int)$category->getCategoryId() : null;
	$categoryTree[$parentId][] = $category;
}
/*foreach($categoryTree as $key => $root)
{
	foreach($root as $key1 => $root1)
	{//echo $root1->getCategoryId().'<br />';
	echo $key1;
	
		if(isset($categoryTree[$key1]))
		{
			$root1->child = $categoryTree[$key1];
			//print_r($categoryTree[$key1]); echo '<br />';
		}//print_r($root1);echo '<br />';
	}
}*///die;
foreach ($categoryTree[null] as $root) {
    $root->getCatName();$cat_id = $root->getCategoryId();
	//echo '<pre>'.print_r($categoryTree[$cat_id],true).'</pre>';die;
	//print_r($categoryTree[$root->getCategoryId()]);die;
    if (isset($categoryTree[$root->getCategoryId()])) {
			//$categoryTree[null][$root->getCategoryId()]->setCategories($categoryTree[$root->getCategoryId()]);
		foreach ($categoryTree[$root->getCategoryId()] as $child) {
          echo  $child->getCatName();
        }
    }
}
        return $categoryTree;
    }
    /**
     * Paginator Helper
     *
     * Pass through a query object, current page & limit
     * the offset is calculated from the page and limit
     * returns an `Paginator` instance, which you can call the following on:
     *
     *     $paginator->getIterator()->count() # Total fetched (ie: `5` posts)
     *     $paginator->count() # Count of ALL posts (ie: `20` posts)
     *     $paginator->getIterator() # ArrayIterator
     *
     * @param Doctrine\ORM\Query $dql   DQL Query Object
     * @param integer            $page  Current page (defaults to 1)
     * @param integer            $limit The total number per page (defaults to 5)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit)
        ->getResult(); // Limit

        return $paginator;
    }
	/*public function _catsIds($cats,$cat_id)
	{
		$data = '';
		foreach($cats as $item)
		{
			if()
			{
				
			}
		}
	}*/
	  private function createDeleteForm(Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
