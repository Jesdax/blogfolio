<?php
/**
 * Created by PhpStorm.
 * User: jesda
 * Date: 10/11/18
 * Time: 01:17
 */

namespace App\Controller;

use App\Entity\Article;
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
     * @Route("/profil", name="profil")
     */
    public function dashbordUserConnected()
    {
        return $this->render('back/index.html.twig');
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


}