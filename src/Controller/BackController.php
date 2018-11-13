<?php
/**
 * Created by PhpStorm.
 * User: jesda
 * Date: 10/11/18
 * Time: 01:17
 */

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\AddingArticleType;
use App\Form\ArticleType;
use App\Form\ArticleWithoutImageType;
use App\Services\ManagerForBlog;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackController extends Controller
{

    const NBR_ARTICLE = 6;
    const NBR_ARTICLE_MANAGE = 6;
    const PAGINATION_BLOG = 5;
    const PAGINATION_MANAGE = 5;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profil/{id}", name="profil", requirements={"id"="\d+$"})
     */
    public function dashbordUserConnected($id = -1)
    {
        if ($id === -1) {
            return $this->redirectToRoute('profil', ['id' => $this->getUser()->getId()]);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findById($id);

        return $this->render('back/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog-information-developpement-web-nouvelles-technologie/{page}", name="blog", requirements={"page"="\d+"})
     */
    public function blogAction($page = 1)
    {

        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->findPublishedWithOffset(($page - 1)*self::NBR_ARTICLE, self::NBR_ARTICLE);

        return $this->render('front/blog.html.twig', [
            'articles' => $articles,
        ]);

    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/article/{id}", name="article-blog", requirements={"id"="\d+"})
     */
    public function articleAction($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->findPublishedById($id);

        return $this->render('front/article.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @param int $page
     * @param ManagerForBlog $articleManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/profil/gestion-articles/{page}", name="gestion-articles", requirements={"page"="\d+"})
     */
    public function manageBlogAction($page = 1, ManagerForBlog $articleManager, Request $request){

        //Requete BDD
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findWithOffset(($page-1)*self::NBR_ARTICLE_MANAGE, self::NBR_ARTICLE_MANAGE);

        //Formulaire
        $article = new Article();
        $form = $this->createForm(AddingArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($articleManager->DefaultArticle());
            $entityManager->flush();
            return $this->redirectToRoute('gestion-articles');
        }




        return $this->render('back/manageBlog.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles,
        ]);
    }

    /**
     * @param Request $request
     * @param ManagerForBlog $articleManager
     * @param $id_article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/profil/gerer-articles/{id_article}", name="edit-article", requirements={"id_article"="\d+"})
     */
    public function editArticleAction(Request $request, ManagerForBlog $articleManager, $id_article){

        //Requete BDD
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findById($id_article);

        $form = '';

        if($article->getImage() === null){
            $form = $this->createForm(ArticleType::class, $article);
        } else {
            $form = $this->createForm(ArticleWithoutImageType::class, $article);
        }

        //Si l'article n'est pas publié, on ajoute le bouton 'Publier'
        if($article->getStatus() === false){
            $form->add('publish', SubmitType::class, ['label' => 'Publier article']);
        }

        //Autre boutons ajoutés
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('delete', SubmitType::class, ['label' => 'Supprimer']);

        $form->handleRequest($request);

        //Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            //Supprimer image
            if ($form->getClickedButton()->getName() == 'delete_image'){
                $articleManager->deleteImage($article);
                return $this->redirectToRoute('edit-article', ['id_article' => $id_article]);
            }

            else{

                //Upload l'image
                if ($article->getImage() !==  null && $form->has('image')){
                    $articleManager->uploadImage($article, $form->get('image')->getData());
                }

                //Action en fonction du bouton
                if ($form->getClickedButton()->getName() == 'delete'){
                    $articleManager->deleteArticle($article);
                }
                elseif ($form->getClickedButton()->getName() == 'save'){
                    $articleManager->createArticle($article);
                }
                elseif ($form->getClickedButton()->getName() == 'publish'){
                    $articleManager->publishArticle($article);
                }
                return $this->redirectToRoute('gestion-articles');
            }
        }


        return $this->render('back/editArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }


}