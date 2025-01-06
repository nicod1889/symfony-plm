<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Programa;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Persona3;
use Psr\Log\LoggerInterface;
use App\Service\YoutubeService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\String\u;

final class AppFixtures extends Fixture {
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly SluggerInterface $slugger,
        private readonly YoutubeService $youtubeService,
        private readonly LoggerInterface $logger
    ) {
    }

    public function load(ObjectManager $manager): void {
        $this->loadUsers($manager);
        $this->loadTags($manager);
        $this->loadPosts($manager);
        $this->loadProgramas($manager);
        $this->loadPersona3($manager);
    }

    private function loadProgramas(ObjectManager $manager): void {
        try {
            $playlistId = 'PLF7Kn3e1aapadYJfWvzACqPG-mqdfOixG';
            $programas = $this->youtubeService->getProgramasFromPlaylist($playlistId);

            foreach ($programas as $programaData) {
                $programa = new Programa();
                $programa->setTitulo($programaData->getTitulo());
                $programa->setFecha($programaData->getFecha());
                $programa->setLinkYoutube($programaData->getLinkYoutube());
                $programa->setMiniatura($programaData->getMiniatura());
                $programa->setEdicion('programa');

                $manager->persist($programa);
            }

            $manager->flush();

            $this->logger->info('Programas cargados correctamente desde YouTube.');
        } catch (\Exception $e) {
            $this->logger->error('Error al cargar los programas: ' . $e->getMessage());
        }
    }

    public function loadPersona3(ObjectManager $manager): void {
        foreach ($this->getPersona3Data() as [$nombre, $edad, $foto, $cumple, $apodo, $instagram, $twitter, $youtube]) {
            $persona = new Persona3();
            $persona->setNombre($nombre);
            $persona->setEdad($edad);
            $persona->setFoto($foto);
            $persona->setNacimiento(new \DateTime($cumple));
            $persona->setApodo($apodo);
            $persona->setInstagram($instagram);
            $persona->setTwitter($twitter);
            $persona->setYoutube($youtube);
    
            $manager->persist($persona);
            $this->addReference($nombre, $persona);
        }
    
        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager): void {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    private function loadTags(ObjectManager $manager): void {
        foreach ($this->getTagData() as $name) {
            $tag = new Tag($name);

            $manager->persist($tag);
            $this->addReference('tag-'.$name, $tag);
        }

        $manager->flush();
    }

    private function loadPosts(ObjectManager $manager): void {
        foreach ($this->getPostData() as [$title, $slug, $summary, $content, $publishedAt, $author, $tags]) {
            $post = new Post();
            $post->setTitle($title);
            $post->setSlug($slug);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setPublishedAt($publishedAt);
            $post->setAuthor($author);
            $post->addTag(...$tags);

            foreach (range(1, 5) as $i) {
                /** @var User $commentAuthor */
                $commentAuthor = $this->getReference('john_user');

                $comment = new Comment();
                $comment->setAuthor($commentAuthor);
                $comment->setContent($this->getRandomText(random_int(255, 512)));
                $comment->setPublishedAt(new \DateTimeImmutable('now + '.$i.'seconds'));

                $post->addComment($comment);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * @return array<array{string, int, string, string, string, string, string, string}>
     */
    private function getPersona3Data(): array {
        return [
            // $personaData = [$nombre, $edad, $foto, $cumple, $apodo, $instagram, $twitter, $youtube];
            ['Lucas Rodriguez', 32, 'https://pbs.twimg.com/media/GOtpyuxWoAAkH7R?format=jpg&name=small', '1992-03-21', 'Luqui', 'https://www.instagram.com/luquitarodrigue/', 'https://twitter.com/LuquitaRodrigue', 'https://www.youtube.com/@LuquitasRodriguez'],
            ['Germán Beder', 41, 'https://pbs.twimg.com/media/GOtrGqDWEAAlXVW?format=jpg&name=small', '1983-05-24', 'Gercho', 'https://www.instagram.com/gbeder/', 'https://twitter.com/gbeder', 'https://www.youtube.com/@GBeder'],
            ['Alfredo Montes de Oca', 44, 'https://pbs.twimg.com/media/GOtrfjgW4AAIbOT?format=jpg&name=small', '1980-09-17', 'Alfre', 'https://www.instagram.com/alfremontes/', 'https://twitter.com/alfremontes', 'https://www.youtube.com/@Alfremontes'],
            ['Roberto Galati', 40, 'https://pbs.twimg.com/media/GOtsLQRXYAA-Nym?format=jpg&name=small', '1984-02-20', 'Rober', 'https://www.instagram.com/robergalati/', 'https://twitter.com/robergalati', 'https://www.youtube.com/@robergalati3366'],
            ['Joaquín Cavanna', 42, 'https://pbs.twimg.com/media/GOw331DWcAAizab?format=jpg&name=small', '1982-04-17', 'Joaco', 'https://www.instagram.com/joacavanna/', 'https://twitter.com/joacavanna', 'https://www.youtube.com/@joacavanna']
        ];
    }

    /**
     * @return array<array{string, string, string, string, array<string>}>
     */
    private function getUserData(): array {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles];
            ['Jane Doe', 'jane_admin', 'kitten', 'jane_admin@symfony.com', [User::ROLE_ADMIN]],
            ['Tom Doe', 'tom_admin', 'kitten', 'tom_admin@symfony.com', [User::ROLE_ADMIN]],
            ['John Doe', 'john_user', 'kitten', 'john_user@symfony.com', [User::ROLE_USER]],
            ['Nicolas Dinolfo', 'nicod1889xyz', '123', 'nicod1889@symfony.com', [User::ROLE_USER]]
        ];
    }

    /**
     * @return string[]
     */
    private function getTagData(): array {
        return [
            'lorem',
            'ipsum',
            'consectetur',
            'adipiscing',
            'incididunt',
            'labore',
            'voluptate',
            'dolore',
            'pariatur',
            'TAG NUEVO',
            'ACA HAY OTRO TAG CHE'
        ];
    }

    /**
     * @throws \Exception
     *
     * @return array<int, array{0: string, 1: AbstractUnicodeString, 2: string, 3: string, 4: \DateTimeImmutable, 5: User, 6: array<Tag>}>
     */
    private function getPostData(): array {
        $posts = [];

        foreach ($this->getPhrases() as $i => $title) {
            // $postData = [$title, $slug, $summary, $content, $publishedAt, $author, $tags, $comments];

            /** @var User $user */
            $user = $this->getReference(['jane_admin', 'tom_admin'][0 === $i ? 0 : random_int(0, 1)]);

            $posts[] = [
                $title,
                $this->slugger->slug($title)->lower(),
                $this->getRandomText(),
                $this->getPostContent(),
                (new \DateTimeImmutable('now - '.$i.'days'))->setTime(random_int(8, 17), random_int(7, 49), random_int(0, 59)),
                // Ensure that the first post is written by Jane Doe to simplify tests
                $user,
                $this->getRandomTags(),
            ];
        }

        return $posts;
    }

    /**
     * @return string[]
     */
    private function getPhrases(): array {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
            'Ubi est barbatus nix',
            'Abnobas sunt hilotaes de placidus vita',
            'Ubi est audax amicitia',
            'Eposs sunt solems de superbus fortis',
            'Vae humani generis',
            'Diatrias tolerare tanquam noster caesium',
            'Teres talis saepe tractare de camerarius flavum sensorem',
            'Silva de secundus galatae demitto quadra',
            'Sunt accentores vitare salvus flavum parses',
            'Potus sensim ad ferox abnoba',
            'Sunt seculaes transferre talis camerarius fluctuies',
            'Era brevis ratione est',
            'Sunt torquises imitari velox mirabilis medicinaes',
            'Mineralis persuadere omnes finises desiderium',
            'Bassus fatalis classiss virtualiter transferre de flavum',
        ];
    }

    private function getRandomText(int $maxLength = 255): string {
        $phrases = $this->getPhrases();
        shuffle($phrases);

        do {
            $text = u('. ')->join($phrases)->append('.');
            array_pop($phrases);
        } while ($text->length() > $maxLength);

        return $text;
    }

    private function getPostContent(): string {
        return <<<'MARKDOWN'
            Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et **dolore magna aliqua**: Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
            deserunt mollit anim id est laborum.

              * Ut enim ad minim veniam
              * Quis nostrud exercitation *ullamco laboris*
              * Nisi ut aliquip ex ea commodo consequat

            Praesent id fermentum lorem. Ut est lorem, fringilla at accumsan nec, euismod at
            nunc. Aenean mattis sollicitudin mattis. Nullam pulvinar vestibulum bibendum.
            Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos
            himenaeos. Fusce nulla purus, gravida ac interdum ut, blandit eget ex. Duis a
            luctus dolor.

            Integer auctor massa maximus nulla scelerisque accumsan. *Aliquam ac malesuada*
            ex. Pellentesque tortor magna, vulputate eu vulputate ut, venenatis ac lectus.
            Praesent ut lacinia sem. Mauris a lectus eget felis mollis feugiat. Quisque
            efficitur, mi ut semper pulvinar, urna urna blandit massa, eget tincidunt augue
            nulla vitae est.

            Ut posuere aliquet tincidunt. Aliquam erat volutpat. **Class aptent taciti**
            sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi
            arcu orci, gravida eget aliquam eu, suscipit et ante. Morbi vulputate metus vel
            ipsum finibus, ut dapibus massa feugiat. Vestibulum vel lobortis libero. Sed
            tincidunt tellus et viverra scelerisque. Pellentesque tincidunt cursus felis.
            Sed in egestas erat.

            Aliquam pulvinar interdum massa, vel ullamcorper ante consectetur eu. Vestibulum
            lacinia ac enim vel placerat. Integer pulvinar magna nec dui malesuada, nec
            congue nisl dictum. Donec mollis nisl tortor, at congue erat consequat a. Nam
            tempus elit porta, blandit elit vel, viverra lorem. Sed sit amet tellus
            tincidunt, faucibus nisl in, aliquet libero.
            MARKDOWN;
    }

    /**
     * @throws \Exception
     *
     * @return array<Tag>
     */
    private function getRandomTags(): array {
        $tagNames = $this->getTagData();
        shuffle($tagNames);
        $selectedTags = \array_slice($tagNames, 0, random_int(2, 4));

        return array_map(function ($tagName) {
            /** @var Tag $tag */
            $tag = $this->getReference('tag-'.$tagName);

            return $tag;
        }, $selectedTags);
    }
}