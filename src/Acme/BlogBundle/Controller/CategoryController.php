<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Entity\Category;
use Acme\BlogBundle\Entity\MultiCategory;
use Acme\BlogBundle\Form\MultiCategoryType;
use Acme\BlogBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("admin/category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="admin_category_index")
     * @Method("GET")
     */
    public function indexAction()
    {//print_r($this->getUser());die;
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('BlogBundle:Category')->findByLocale('en');

        return $this->render('category/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new category entity.
     *
     * @Route("/new", name="admin_category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
         $lang_arr = $this->getDoctrine()->getManager()->getRepository("BlogBundle:Language")->findAll();
		$category = new Category();
		//print_r($lang_arr);die;
	  foreach($lang_arr as $key => $lang){
		$category->setLocale($lang);
		$mcat = new MultiCategory();
        $mcat->setCatName('');
		$mcat->setDescriptionCat('');
		$mcat->setLocale($lang->getLocale());
        $category->getMultiCategories()->add($mcat);
	  }
       // $form = $this->createForm('Acme\BlogBundle\Form\CategoryType', $category);
       // $form->handleRequest($request);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			$qb = $this->getDoctrine()->getEntityManager()->getConnection();
			$category_id = $this->getDoctrine()->getEntityManager()->createQuery("SELECT MAX(b.categoryId) FROM BlogBundle:Category b")->getResult()[0];
			foreach($category->getMultiCategories() as $key => $qu){	
			$slug = $this->transliterate($qu->getCatName());
			$query = $qb->insert('category',array('cat_id' => '','category_id' => $category_id[1] + 1,'parent_id' => $category->getParentId()->getCategoryId(),'locale' => $qu->getLocale(),'cat_name' => $qu->getCatName(),'description_cat' => $qu->getDescriptionCat(),'slug' => $slug,'created' => '0000-00-00'));	
			}
			
            return $this->redirectToRoute('admin_category_show', array('cat_id' => 1));
        }

        return $this->render('category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }
	
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

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{cat_id}", name="admin_category_show")
     * @Method("GET")
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('category/show.html.twig', array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{cat_id}/edit", name="admin_category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
		//print_r($categories);die;
        $deleteForm = $this->createDeleteForm($category);  
		$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
        'SELECT p FROM BlogBundle:Category p WHERE p.categoryId = :categoryId'
        )->setParameter('categoryId',$category->getCategoryId());
        $categories = $query->getResult();
		$category = new Category();
		foreach($categories as $key => $categories1){
        $categories1->setLocale($categories1->getLocale());
		//$categories1->setParentId($categories1->getParentId());
		$mcat = new MultiCategory();
        $mcat->setCatName($categories1->getCatName());
		$mcat->setDescriptionCat($categories1->getDescriptionCat());
		$mcat->setCat_id($categories1->getCat_id());
		$mcat->setParentId($categories1->getParentId());
        $category->getMultiCategories()->add($mcat);
	  }
	    $editForm = $this->createForm('Acme\BlogBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
          //print_r($category->getParentId());die;
		  foreach($category->getMultiCategories() as $key => $qu){
			//print_r($categories->getParentId());die;
			$qb = $this->getDoctrine()->getManager();
		$slug = $this->transliterate($qu->getCatName());
		$query = $qb->createQueryBuilder()->update('BlogBundle:Category', 'c')
        ->set('c.cat_name', ':cat_name')
        ->set('c.description_cat', ':description_cat')
		->set('c.parentId', ':parent_id')
		->set('c.slug', ':slug')
        ->where('c.cat_id = :cat_id')
        ->setParameter('cat_name', $qu->getCatName())
		->setParameter('description_cat', $qu->getDescriptionCat())
		->setParameter('parent_id', $category->getParentId())
		->setParameter('slug', $slug)
		->setParameter('cat_id', $qu->getCat_id())
        ->getQuery();
		$query->execute();
		}
            return $this->redirectToRoute('admin_category_edit', array('cat_id' => 1));
        }

        return $this->render('category/edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{cat_id}", name="admin_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $qb->delete('BlogBundle:Category','b')
            ->where('b.categoryId = :id');
            $qb->setParameter('id',$category->getCategoryId())->getQuery()->execute();
        }

        return $this->redirectToRoute('admin_category_index');
    }
public function getCategories()
	{
		$categories = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findByLocale('en');
		//print_r($categories);die;
		foreach($categories as $key => $category)
		{
			$cats[$category->getCatName()] = $category->getCat_id(); 
		}
		return $cats;
	}
    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_category_delete', array('cat_id' => $category->getCat_id())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
