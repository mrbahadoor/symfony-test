<?php

namespace App\Controller;

use App\Entity\BlogPost;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }    

    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 3}, requirements={"page"="\d+"}, methods={"GET"})
     */
    public function list($page, Request $request)
    {
        $repository = $this->doctrine->getRepository(BlogPost::class);
        $items = $repository->findAll();
        
        $limit = $request->get('limit', 10);
        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function(BlogPost $item){
                return $this->generateUrl('blog_by_slug', ['slug' => $item->getSlug()]);
            }, $items),
        ]);
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function post(BlogPost $post)
    {
        // Same as find($id) on repository
        return $this->json($post);
        // return $this->json(
        //     $this->doctrine->getRepository(BlogPost::class)->find($id)
        // );
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug", methods={"GET"})
     *
     */
    public function postBySlug($slug)
    {        
        return $this->json(
            $this->doctrine->getRepository(BlogPost::class)->findOneBy(['slug' => $slug])
        );
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer){
        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        $em = $this->doctrine->getManager();
        $em->persist($blogPost);
        $em->flush();
        
        return $this->json($blogPost);
    }

    /**
     * @Route("/post/{id}", name="blog_delete", methods={"DELETE"})
     */
    public function delete(BlogPost $post)
    {
        $em = $this->doctrine->getManager();
        $em->remove($post);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);

    }

}