<?php
/**
 * Created by PhpStorm.
 * User: jesda
 * Date: 11/11/18
 * Time: 12:47
 */

namespace App\Services;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ManagerForBlog
{
    private $em;
    private $storage;
    private $fileManager;
    private $imageDirectory;

    public function __construct(EntityManagerInterface $entityManager, ManagerForFile $fileManager, TokenStorageInterface $storage, $imageDirectory)
    {
        $this->em = $entityManager;
        $this->storage = $storage;
        $this->fileManager = $fileManager;
        $this->imageDirectory = $imageDirectory;
    }

    public function defaultArticle()
    {
        $article = new Article();
        $article->setTitle('L\'innovation marque le début du futur.')
            ->setContent('La nouvelle génération de robot ...')
            ->setStatus(false)
            ->setImage(null)
            ->setCreatedAt(new \DateTime())
            ->setPublishingDate(null)
            ->setUser($this->storage->getToken()->getUser());

        return $article;

    }

    public function createArticle(Article $article)
    {
        $article->setCreatedAt(new \DateTime());
        $this->em->flush();
    }

    public function updateArticle(Article $article)
    {
        $article->setModificationDate(new \DateTime());
        $this->em->flush();
    }

    public function deleteArticle(Article $article)
    {
        $this->em->remove($article);
        $this->em->flush();
    }

    public function publishArticle(Article $article)
    {
        $article->setPublishingDate(new \DateTime())->setModificationDate(new \DateTime())->setStatus(true);
        $this->em->flush();
    }

    public function uploadImage(Article $article, UploadedFile $file)
    {
        $fileName = $this->fileManager->upload($file, $this->imageDirectory);
        $article->setImage($fileName);
    }

    public function deleteImage(Article $article)
    {
        $this->fileManager->delete($this->imageDirectory.'/'.$article->getImage());
        $article->setImage(null);
        $this->em->flush();
    }

}