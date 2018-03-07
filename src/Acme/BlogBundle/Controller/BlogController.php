<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Entity\Language;
use Acme\BlogBundle\Entity\Blog;
use Acme\BlogBundle\Entity\Title;
use Acme\BlogBundle\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
//use Acme\BlogBundle\TransliteratorTrait;

/**
 * Blog controller.
 *
 * @Route("/blog")
 */
class BlogController extends Controller
{
	//use TransliteratorTrait;
	
    /**
     * Lists all blog entities.
     *
     * @Route("/index", name="blog_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $blogs = $em->getRepository('BlogBundle:Blog')->findByLocale('en');
        return $this->render('blog/index.html.twig', array(
            'blogs' => $blogs,
        ));
    }

    /**
     * Creates a new blog entity.
     *
     * @Route("/new", name="blog_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		//$lang_arr = array(0 => 'en',1 => 'ru',2 => 'ua');
        $lang_arr = $this->getDoctrine()->getManager()->getRepository("BlogBundle:Language")->findAll();
		$blog = new Blog();
	  foreach($lang_arr as $key => $lang){
		$blog->setLocale($lang);
		$title = new Title();
        $title->setTitle('');
		$title->setBody('');
		$title->setLocale($lang->getLocale());	
        //$ids = $;
		$blog->getTitles()->add($title);
	  }//print_r($blog);
		$form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			$category_id = $blog->getCategoryId()->getCategoryId();
			$qb = $this->getDoctrine()->getEntityManager()->getConnection();
			$product_id = $this->getDoctrine()->getEntityManager()->createQuery("SELECT MAX(b.productId) FROM BlogBundle:Blog b")->getResult()[0];
			foreach($blog->getTitles() as $key => $qu){	
			$slug = $this->transliterate($qu->getTitle());
			$query = $qb->insert('blog',array('id' => '','product_id' => $product_id[1] + 1,'category_id' => $category_id,'locale' => $qu->getLocale(),'title' => $qu->getTitle(),'body' => $qu->getBody(),'slug' => $slug,'created' => '0000-00-00'));	
			}
			
            return $this->redirectToRoute('blog_show', array('id' => 3));
        }

        return $this->render('blog/new.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blog entity.
     *
     * @Route("/{id}", name="blog_show")
     * @Method("GET")
     */
    public function showAction(Blog $blog)
    {
        $deleteForm = $this->createDeleteForm($blog);

        return $this->render('blog/show.html.twig', array(
            'blog' => $blog,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blog entity.
     *
     * @Route("/{id}/edit", name="blog_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Blog $blog)
    {
        $deleteForm = $this->createDeleteForm($blog);  
		$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
        'SELECT p FROM BlogBundle:Blog p WHERE p.productId = :productId'
        )->setParameter('productId',$blog->getProductId());
        $blogs = $query->getResult();
		$blog = new Blog();
		foreach($blogs as $key => $blog1){
        $blog1->setLocale($blog1->getLocale());
		$title = new Title();
        $title->setTitle($blog1->getTitle());
		$title->setBody($blog1->getBody());
		$title->setId($blog1->getId());
        $blog->getTitles()->add($title);
	  }
		$editForm = $this->createForm('Acme\BlogBundle\Form\BlogType', $blog);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
		   $category_id = $blog->getCategoryId()->getCategoryId();
		   foreach($blog->getTitles() as $key => $qu){
			$qb = $this->getDoctrine()->getManager();
		$slug = $this->transliterate($qu->getTitle());
		$query = $qb->createQueryBuilder()->update('BlogBundle:Blog', 'c')
        ->set('c.title', ':title')
        ->set('c.body', ':body')
		->set('c.categoryId', ':category_id')
		->set('c.slug', ':slug')
        ->where('c.id = :id')
        ->setParameter('title', $qu->getTitle())
		->setParameter('body', $qu->getBody())
		->setParameter('category_id',$category_id)
		->setParameter('slug', $slug)
		->setParameter('id', $qu->getId())
        ->getQuery();
		$query->execute();
		}
            return $this->redirectToRoute('blog_edit', array('id' => $blog->getTitles()[0]->getId()));
			
		}

        return $this->render('blog/edit.html.twig', array(
            'blog' => $blog,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blog entity.
     *
     * @Route("/{id}", name="blog_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Blog $blog)
    {
        $form = $this->createDeleteForm($blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $qb->delete('BlogBundle:Blog','b')
            ->where('b.productId = :id');
            $qb->setParameter('id',$blog->getProductId())->getQuery()->execute();
        }

        return $this->redirectToRoute('blog_index');
    }

    /**
     * Creates a form to delete a blog entity.
     *
     * @param Blog $blog The blog entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
	protected function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		'і' => 'i',   'є' => 'ye',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		'І' => 'I',   'Є' => 'Ye',
        
	);
    return strtr($string, $converter);
}
   protected function transliterate($str) {
    // переводим в транслит
    $str = $this->rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}
    private function createDeleteForm(Blog $blog)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_delete', array('id' => $blog->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
