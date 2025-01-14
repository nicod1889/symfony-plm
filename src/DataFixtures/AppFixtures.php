<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Edicion;
use App\Entity\Post;
use App\Entity\Programa;
use App\Entity\Vlog;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Persona3;
use App\Entity\Rol;
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
        $this->loadEdiciones($manager);
        $this->loadProgramas($manager);
        $this->loadProgramasManual($manager);
        $this->loadPersona3($manager);
        $this->loadVlogs($manager);
        $this->vincularConductoresYColumnistas($manager);
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
                $programa->setMiniaturaPequeña($programaData->getMiniaturaPequeña());
                $programa->setMiniaturaGrande($programaData->getMiniaturaGrande());
                $manager->persist($programa);
            }
    
            $manager->flush();
            $this->logger->info('Programas cargados correctamente desde YouTube.');
        } catch (\Exception $e) {
            $this->logger->error('Error al cargar los programas: ' . $e->getMessage());
        }
    }

    private function loadProgramasManual(ObjectManager $manager): void {
        $programa010322 = new Programa();
        $programa010322->setTitulo('#ParenLaMano completo - 01/03');
        $programa010322->setFecha(\DateTime::createFromFormat('d-m-Y', '01-03-2022'));
        $manager->persist($programa010322);
        $manager->flush();

        $programa020322 = new Programa();
        $programa020322->setTitulo('#ParenLaMano completo - 02/03');
        $programa020322->setFecha(\DateTime::createFromFormat('d-m-Y', '01-03-2022'));
        $manager->persist($programa020322);
        $manager->flush();

        $programa030322 = new Programa();
        $programa030322->setTitulo('#ParenLaMano completo - 03/03');
        $programa030322->setFecha(\DateTime::createFromFormat('d-m-Y', '01-03-2022'));
        $manager->persist($programa030322);
        $manager->flush();

        $programa040322 = new Programa();
        $programa040322->setTitulo('#ParenLaMano completo - 04/03');
        $programa040322->setFecha(\DateTime::createFromFormat('d-m-Y', '01-03-2022'));
        $manager->persist($programa040322);
        $manager->flush();

        $programa070322 = new Programa();
        $programa070322->setTitulo('#ParenLaMano completo - 07/03');
        $programa070322->setFecha(\DateTime::createFromFormat('d-m-Y', '01-03-2022'));
        $manager->persist($programa070322);
        $manager->flush();

        $programa180322 = new Programa();
        $programa180322->setTitulo('#ParenLaMano Completo - 18/03 | Vorterix');
        $programa180322->setFecha(\DateTime::createFromFormat('d-m-Y', '01-03-2022'));
        $manager->persist($programa180322);
        $manager->flush();

        $programa040422 = new Programa();
        $programa040422->setTitulo('#ParenLaMano Completo - 04/04 | Vorterix');
        $programa040422->setFecha(\DateTime::createFromFormat('d-m-Y', '04-04-2022'));
        $manager->persist($programa040422);
        $manager->flush();

        $programa180522 = new Programa();
        $programa180522->setTitulo('#ParenLaMano Completo - 18/05 | Vorterix');
        $programa180522->setFecha(\DateTime::createFromFormat('d-m-Y', '18-05-2022'));
        $manager->persist($programa180522);
        $manager->flush();

        $programa251022 = new Programa();
        $programa251022->setTitulo('#ParenLaMano Completo - 25/10 | Vorterix');
        $programa251022->setFecha(\DateTime::createFromFormat('d-m-Y', '25-10-2022'));
        $manager->persist($programa251022);
        $manager->flush();

        $programa111122 = new Programa();
        $programa111122->setTitulo('#ParenLaMano Completo - 11/11 | Vorterix');
        $programa111122->setFecha(\DateTime::createFromFormat('d-m-Y', '11-11-2022'));
        $manager->persist($programa111122);
        $manager->flush();

        $programa181122 = new Programa();
        $programa181122->setTitulo('#ParenLaMano Completo - 18/11 | Vorterix');
        $programa181122->setFecha(\DateTime::createFromFormat('d-m-Y', '18-11-2022'));
        $manager->persist($programa181122);
        $manager->flush();
    }

    private function loadVlogs(ObjectManager $manager): void {
        try {
            $playlists = [
                'PLF7Kn3e1aapYCnApa8fW4kvvAjqb3-h9K' => 'Vlog Londres - Final FA Cup 2022 | Luquitas y Alfre',
                'PLF7Kn3e1aapav1JcV8ioH7fZYb5chwsrW' => 'Vlog Qatar - Mundial 2022',
                'PLF7Kn3e1aapZjXCbs4rhAwnfR-NaKqphn' => 'Vlog Qatar - Mundial 2022 | Germán',
                'PLF7Kn3e1aapYwxjKB2ksUG_ZxuiLT7SKp' => 'Vlog Estambul - Final Champions 2023 | Luquitas y Alfre',
                'PLF7Kn3e1aapbBfYeYydyXIKV5Yoo6OKiA' => 'Vlog España - Velada del año 2023',
                'PLF7Kn3e1aapY7xcOmcOfWPV00FTfEsMWj' => 'Vlog España - Velada del año 2023 | Germán',
                'PLF7Kn3e1aapZB3JLchuMENVSAFOV3pWAm' => 'Vlog Francia - Mundial de rugby 2023 | Alfre',
                'PLF7Kn3e1aapbH4gVOEnxqVEHJEi5KdvAB' => 'Vlog España - La Liga Experience | Alfre',
                'PLF7Kn3e1aapbxJ0DNKjDFRrI0JjtaxTFy' => 'Vlog Japón | Luquitas',
                'PLF7Kn3e1aapaODjpun5zbemcDyuXRXVj1' => 'Vlog Estados Unidos - Final Superbowl 2024 | Luquitas',
                'PLF7Kn3e1aapZQowsqGo50cF1sKFKTh_WY' => 'Vlog Londres - Final Champions 2024 | Luquitas y Alfre',
                'PLF7Kn3e1aapZ5mkKmIBBAT_n_dZRWV-PH' => 'Vlog Roma | Luquitas',
                'PLF7Kn3e1aapb3-D3PYRaG9DxAFs3u0ECm' => 'Vlog EEUU y España - Copa América y Velada del año 2024',
                'PLF7Kn3e1aapb4FGC9JWr2pfeY2wodUyy1' => 'Vlog EEUU y España - Copa América y Velada del año 2024 | Germán',
                'PLF7Kn3e1aapZHZoqIW5kyOfT_9U2WRZyp' => 'Vlog EEUU - Copa América 2024 | Alfre',
                'PLF7Kn3e1aapYIrmgWkGJ9NMKpVpq2jLIO' => 'Vlog Berlín y Paris | Alfre',
                'PLF7Kn3e1aapYQPQjb-Hr74tGjs_D56yep' => 'Vlog París - Juegos Olimpicos 2024',
                'PLF7Kn3e1aapb3qsy9bC5kUCY8sU40ZLCu' => 'Vlog México - Luquitas en la F1',
                'PLF7Kn3e1aapZMQNtXGz-r4ompft78C_gk' => 'Párense de Manos I',
                'PLF7Kn3e1aapbbzSkcDlQasjjbZzp3Mso6' => 'Párense de Manos II'
            ];
            $edicionRepository = $manager->getRepository(Edicion::class);
    
            foreach ($playlists as $playlistId => $nombreEdicion) {
                $vlogs = $this->youtubeService->getVlogsFromPLaylist($playlistId);
    
                foreach ($vlogs as $vlogData) {
                    $vlog = new Vlog();
                    $vlog->setTitulo($vlogData->getTitulo());
                    $vlog->setMiniaturaPequeña($vlogData->getMiniaturaPequeña());
                    $vlog->setMiniaturaGrande($vlogData->getMiniaturaGrande());
                    $edicion = $edicionRepository->findByNombre($nombreEdicion);
    
                    if ($edicion) {
                        $vlog->setEdicion($edicion);
                    } else {
                        $this->logger->error('No se encontró la edición con nombre: ' . $nombreEdicion);
                    }
    
                    $manager->persist($vlog);
                }
            }
    
            $manager->flush();
            $this->logger->info('Vlogs cargados correctamente desde YouTube.');
        } catch (\Exception $e) {
            $this->logger->error('Error al cargar los vlogs: ' . $e->getMessage());
        }
    }

    private function vincularConductoresYColumnistas(ObjectManager $manager): void {
        try {
            $filePath = 'data/programas_conductores.json';   
            $jsonData = file_get_contents($filePath);
            $programasData = json_decode($jsonData, true);
            $personaRepository = $manager->getRepository(Persona3::class);
            $edicionRepository = $manager->getRepository(Edicion::class);
    
            foreach ($programasData as $programaData) {
                $programa = $manager->getRepository(Programa::class)->findOneBy(['linkYoutube' => $programaData['youtube']]);
                if (!$programa) {
                    $this->logger->error('No se encontró el programa con el título: ' . $programaData['youtube'] . 'y fecha ' . $programaData['fecha']);
                    continue;
                }

                $programa->setTitulo($programaData['titulo']);
                $programa->setEdicion($programaData['edicion']);
                $programa->setlinkSpotify($programaData['spotify']);
                $programa->setComentario($programaData['comentario']);
                
                $fecha = \DateTime::createFromFormat('d-m-Y', $programaData['fecha']);
                if ($fecha === false) {
                    $this->logger->error('Formato de fecha inválido: ' . $programaData['fecha']);
                    continue;
                }
                $programa->setFecha($fecha);

                $edicion = $edicionRepository->findOneBy(['nombre' => $programaData['edicion']]);
                if ($edicion) {
                    $programa->setEdicionClass($edicion);
                } else {
                    $this->logger->error('No se encontró la edición con nombre: ' . $programaData['edicion']);
                }

                $conductores = $personaRepository->findBy(['id' => $programaData['conductores']]);
                foreach ($conductores as $conductor) {
                    $programa->addConductor($conductor);
                }


                $columnistas = $personaRepository->findBy(['id' => $programaData['columnistas']]);
                foreach ($columnistas as $columnista) {
                    $programa->addColumnista($columnista);
                }

                $invitados = $personaRepository->findBy(['id' => $programaData['invitados']]);
                foreach ($invitados as $invitado) {
                    $programa->addInvitado($invitado);
                }
    
                $manager->persist($programa);
            }
    
            $manager->flush();   
        } catch (\Exception $e) {
            $this->logger->error('Error al vincular conductores y columnistas: ' . $e->getMessage());
        }
    }

    public function loadPersona3(ObjectManager $manager): void {
        foreach ($this->getPersona3Data() as [$nombre, $edad, $foto, $nacimiento, $apodo, $rubro, $instagram, $twitter, $youtube]) {
            $persona = new Persona3();
            $persona->setNombre($nombre);
            $persona->setEdad($edad);
            $persona->setFoto($foto);
            $persona->setNacimiento(new \DateTime($nacimiento));
            $persona->setApodo($apodo);
            $persona->setRubro($rubro);
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

    private function loadEdiciones(ObjectManager $manager): void {
        foreach ($this->getEdicionData() as [$nombre, $tipo]) {
            $edicion = new Edicion();
            $edicion->setNombre($nombre);
            $edicion->setTipo($tipo);

            $manager->persist($edicion);
            $this->addReference($nombre, $edicion);
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
            // $personaData = [$nombre, $edad, $foto, $nacimiento, $apodo, $rubro, $instagram, $twitter, $youtube];
            ['Lucas Rodriguez', 32, 'https://pbs.twimg.com/media/GOtpyuxWoAAkH7R?format=jpg&name=small', '21-3-1992', 'Luqui', 'Comediante', 'https://www.instagram.com/luquitarodrigue/', 'https://twitter.com/LuquitaRodrigue', 'https://www.youtube.com/@LuquitasRodriguez'],
            ['Germán Beder', 41, 'https://pbs.twimg.com/media/GOtrGqDWEAAlXVW?format=jpg&name=small', '24-5-1983', 'Gercho', 'Periodista, Escritor/a', 'https://www.instagram.com/gbeder/', 'https://twitter.com/gbeder', 'https://www.youtube.com/@GBeder'],
            ['Alfredo Montes de Oca', 44, 'https://pbs.twimg.com/media/GOtrfjgW4AAIbOT?format=jpg&name=small', '17-9-1980', 'Alfre', 'Periodista', 'https://www.instagram.com/alfremontes/', 'https://twitter.com/alfremontes', 'https://www.youtube.com/@Alfremontes'],
            ['Roberto Galati', 40, 'https://pbs.twimg.com/media/GOtsLQRXYAA-Nym?format=jpg&name=small', '20-2-1984', 'Rober', 'Comediante', 'https://www.instagram.com/robergalati/', 'https://twitter.com/robergalati', 'https://www.youtube.com/@robergalati3366'],
            ['Joaquín Cavanna', 42, 'https://pbs.twimg.com/media/GOw331DWcAAizab?format=jpg&name=small', '17-4-1982', 'Joaco', 'Periodista', 'https://www.instagram.com/joacavanna/', 'https://twitter.com/joacavanna', 'https://www.youtube.com/@joacavanna'],
            ['Tomás Rebord', 31, 'https://www.planetadelibros.com.ar/usuaris/autores/fotos/85/original/000084137_1_TomsRebord_202403111655.jpg', '6-7-1993', 'Rebord', 'Abogado/a, Conductor/a', 'NULL', 'NULL', 'NULL'],
            ['Juan Igal', 25, 'https://pbs.twimg.com/media/GOwzhqtWIAMsZ-C?format=jpg&name=small', '7-7-1999', 'Igal', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Noski', 125, 'https://pbs.twimg.com/media/GhMXCmqXYAAhfUQ?format=jpg&name=small', '1-1-1900', 'Noski', 'Twittero/a', 'NULL', 'NULL', 'NULL'],
            ['Juan Castro', 43, 'https://pbs.twimg.com/media/GhMXp3eXEAA3XBg?format=jpg&name=small', '29-1-1981', 'Juancaster', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Alexis Valido', 40, 'https://pbs.twimg.com/media/GOwyvV3XIAEWoEf?format=jpg&name=small', '17-7-1984', 'Alexis', 'Productor/a, Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Julian Kartun', 41, 'NULL', '7-11-1983', 'NULL', 'Músico, Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Luis Ventura', 68, 'NULL', '14-1-1956', 'NULL', 'Periodista, DT', 'NULL', 'NULL', 'NULL'],
            ['Gordo Ventilador', 125, 'NULL', '1-1-1900', 'NULL', 'Animador/a, Influencer', 'NULL', 'NULL', 'NULL'],
            ['Lucas Pratto', 35, 'NULL', '4-6-1989', 'NULL', 'Futbolista', 'NULL', 'NULL', 'NULL'],
            ['Fernanda Metilli', 40, 'NULL', '13-6-1984', 'NULL', 'Comediante, Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Rusherking', 24, 'NULL', '20-5-2000', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['FMK', 25, 'NULL', '27-1-1999', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['El Demente', 30, 'NULL', '19-12-1994', 'NULL', 'Streamer, Influencer', 'NULL', 'NULL', 'NULL'],
            ['Toto Kirzner', 26, 'NULL', '17-8-1998', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Juan Pablo Varsky', 54, 'NULL', '27-10-1970', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Goncho Banzas', 29, 'NULL', '14-9-1995', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Lit Killah', 25, 'NULL', '4-10-1999', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Fran Gomez', 31, 'NULL', '2-11-1993', 'NULL', 'Comediante, Influencer', 'NULL', 'NULL', 'NULL'],
            ['Alexandra Kohan', 53, 'NULL', '29-1-1971', 'NULL', 'Psicoanalista, Docente', 'NULL', 'NULL', 'NULL'],
            ['Dillom', 24, 'NULL', '5-12-2000', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Muzzu', 125, 'NULL', '1-1-1900', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Duki', 28, 'NULL', '24-6-1996', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Federico D Elía', 58, 'NULL', '4-10-1966', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Manu Olivari', 39, 'NULL', '1-4-1985', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Danny Ocean', 32, 'NULL', '5-5-1992', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Palito', 125, 'NULL', '1-1-1900', 'NULL', 'Twittero/a', 'NULL', 'NULL', 'NULL'],
            ['Juan Marconi', 37, 'NULL', '17-10-1987', 'NULL', 'Periodista, Conductor', 'NULL', 'NULL', 'NULL'],
            ['Oveja Hernandez', 61, 'NULL', '1-11-1963', 'NULL', 'Exbasquetbolista, Director Técnico (Futbol)', 'NULL', 'NULL', 'NULL'],
            ['Matías Martin', 54, 'NULL', '27-10-1970', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Nicolás Laprovíttola', 34, 'NULL', '31-1-1990', 'NULL', 'Basquetbolista', 'NULL', 'NULL', 'NULL'],
            ['Ariel Senosiain', 45, 'NULL', '3-7-1979', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['José Montesano', 53, 'NULL', '23-1-1971', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Saramalacara', 24, 'NULL', '8-11-2000', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Grego Rossello', 33, 'NULL', '13-8-1991', 'NULL', 'Comediante, Influencer', 'NULL', 'NULL', 'NULL'],
            ['Unicornio', 25, 'NULL', '7-6-1999', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Topa', 49, 'NULL', '11-10-1975', 'NULL', 'Actor/Actriz, Animador, Musico/a', 'NULL', 'NULL', 'NULL'],
            ['BB Asul', 27, 'NULL', '26-6-1997', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Migue Granados', 38, 'NULL', '2-9-1986', 'NULL', 'Comediante, Conductor', 'NULL', 'NULL', 'NULL'],
            ['Mono de Kapanga', 55, 'NULL', '12-4-1969', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Agustín Bernasconi (MYA)', 28, 'NULL', '15-10-1996', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Máximo Espíndola (MYA)', 30, 'NULL', '3-12-1994', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Nico Villalba', 25, 'NULL', '23-10-1999', 'NULL', 'Jugador de Esports (FIFA)', 'NULL', 'NULL', 'NULL'],
            ['Facu Campazzo', 33, 'NULL', '23-3-1991', 'NULL', 'Basquetbolista', 'NULL', 'NULL', 'NULL'],
            ['Louta', 30, 'NULL', '22-6-1994', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Patricio Garino', 31, 'NULL', '17-5-1993', 'NULL', 'Basquetbolista', 'NULL', 'NULL', 'NULL'],
            ['Davo Xeneize', 22, 'NULL', '4-12-2002', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Gaspar Benegas', 47, 'NULL', '7-1-1978', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Alejandro Fantino', 53, 'NULL', '26-9-1971', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Gonzalo Heredia', 42, 'NULL', '12-3-1982', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Seba Varela del Rio', 37, 'NULL', '11-6-1987', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Javi Lanza', 125, 'NULL', '1-1-1900', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Ima Rodriguez', 28, 'NULL', '5-3-1996', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Diego Latorre', 55, 'NULL', '4-8-1969', 'NULL', 'Exfutbolista, Periodista', 'NULL', 'NULL', 'NULL'],
            ['Valentin Torres Erwerle', 20, 'NULL', '8-12-2004', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Hilda Lizarazu', 61, 'NULL', '12-10-1963', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Violeta Urtizberea', 39, 'NULL', '19-2-1985', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Elio Rossi', 61, 'NULL', '4-5-1963', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Florian', 29, 'NULL', '11-5-1995', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Carlos Maslaton', 66, 'NULL', '19-12-1958', 'NULL', 'Abogado, Analista Financiero', 'NULL', 'NULL', 'NULL'],
            ['Lucas Lauriente', 32, 'NULL', ' 24-1-1992', 'NULL', 'Comediante', 'NULL', 'NULL', 'NULL'],
            ['Sergio Goycochea', 61, 'NULL', '17-10-1963', 'NULL', 'Exfutbolista', 'NULL', 'NULL', 'NULL'],
            ['Zambayonny', 51, 'NULL', '8-9-1973', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Piti Fernandez', 42, 'NULL', '14-11-1982', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Hector Baldassi', 59, 'NULL', '5-1-1966', 'NULL', 'Ex-árbitro', 'NULL', 'NULL', 'NULL'],
            ['Diego Ripoll', 50, 'NULL', '13-1-1974', 'NULL', 'Locutor', 'NULL', 'NULL', 'NULL'],
            ['Benja Amadeo', 40, 'NULL', '22-4-1984', 'NULL', 'Actor/Actriz, Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Clemente Cancela', 47, 'NULL', '10-10-1977', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Luis Rubio', 59, 'NULL', '19-11-1965', 'NULL', 'Comediante, Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Juariu', 38, 'NULL', '11-1-1986', 'NULL', 'Influencer', 'NULL', 'NULL', 'NULL'],
            ['Peto Menahem', 54, 'NULL', '28-2-1970', 'NULL', 'Actor/Actriz, Comediante', 'NULL', 'NULL', 'NULL'],
            ['Sergio Rondina', 53, 'NULL', '3-11-1971', 'NULL', 'Exfutbolista, Director Técnico (Futbol)', 'NULL', 'NULL', 'NULL'],
            ['Hernán Casciari', 53, 'NULL', '16-3-1971', 'NULL', 'Escritor/a', 'NULL', 'NULL', 'NULL'],
            ['Patricio Sardelli (Airbag)', 38, 'NULL', '26-1-1986', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Guido Sardelli (Airbag)', 36, 'NULL', '5-12-1988', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Chino Leunis', 44, 'NULL', '9-9-1980', 'NULL', 'Conductor/a', 'NULL', 'NULL', 'NULL'],
            ['Emmanuel Horvilleur', 50, 'NULL', '2-1-1975', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Ricky Blanco', 125, 'NULL', '1-1-1900', 'NULL', 'Personalidad de internet', 'NULL', 'NULL', 'NULL'],
            ['Sebastian De Caro', 49, 'NULL', '15-12-1975', 'NULL', 'Director/a de Cine', 'NULL', 'NULL', 'NULL'],
            ['Delfina Pignatiello', 24, 'NULL', '19-4-2000', 'NULL', 'Exnadador/a', 'NULL', 'NULL', 'NULL'],
            ['Natalia Carulias', 49, 'NULL', '19-10-1975', 'NULL', 'Comediante', 'NULL', 'NULL', 'NULL'],
            ['Leo Gabes', 125, 'NULL', '1-1-1900', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Adrian Lacroix', 125, 'NULL', '1-1-1900', 'NULL', 'Mago', 'NULL', 'NULL', 'NULL'],
            ['CAE', 55, 'NULL', '20-10-1969', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Paulina Cocina', 48, 'NULL', '22-7-1976', 'NULL', 'Cocinera, Influencer', 'NULL', 'NULL', 'NULL'],
            ['José María Listorti', 51, 'NULL', '4-3-1973', 'NULL', 'Comediante, Conductor/a', 'NULL', 'NULL', 'NULL'],
            ['Juan Carlos Baglietto', 69, 'NULL', '14-6-1955', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['El Bananero', 48, 'NULL', '12-9-1976', 'NULL', 'Comediante, Influencer', 'NULL', 'NULL', 'NULL'],
            ['Sergio Massa', 52, 'NULL', '28-4-1972', 'NULL', 'Político/a', 'NULL', 'NULL', 'NULL'],
            ['Roberto Moldavsky', 62, 'NULL', '12-9-1962', 'NULL', 'Comediante, Escritor/a', 'NULL', 'NULL', 'NULL'],
            ['Mariano Llinas', 49, 'NULL', '10-2-1975', 'NULL', 'Director/a de Cine', 'NULL', 'NULL', 'NULL'],
            ['Pablo Giralt', 50, 'NULL', '5-4-1974', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Momo', 125, 'NULL', '1-1-1900', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Felipe Pigna', 65, 'NULL', '29-5-1959', 'NULL', 'Historiador/a', 'NULL', 'NULL', 'NULL'],
            ['Gaston Edul', 30, 'NULL', '31-12-1994', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['José Chatruc', 48, 'NULL', '9-11-1976', 'NULL', 'Exfutbolista', 'NULL', 'NULL', 'NULL'],
            ['Martín Garabal', 41, 'NULL', '7-11-1983', 'NULL', 'Comediante, Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Ruben Dario Insua', 63, 'NULL', '17-4-1961', 'NULL', 'Exfutbolista, Director Técnico (Futbol)', 'NULL', 'NULL', 'NULL'],
            ['Luken', 27, 'NULL', '25-3-1997', 'NULL', 'Jugador de Esports (Counter), Streamer', 'NULL', 'NULL', 'NULL'],
            ['Lucas Zelarayán', 125, 'NULL', '1-1-1900', 'NULL', 'Futbolista', 'NULL', 'NULL', 'NULL'],
            ['Renzo Saravia', 125, 'NULL', '1-1-1900', 'NULL', 'Futbolista', 'NULL', 'NULL', 'NULL'],
            ['Wanchope Ábila', 125, 'NULL', '1-1-1900', 'NULL', 'Futbolista', 'NULL', 'NULL', 'NULL'],
            ['Pali Bilbao', 125, 'NULL', '1-1-1900', 'NULL', 'Productor', 'NULL', 'NULL', 'NULL'],
            ['Messismo', 125, 'NULL', '1-1-1900', 'NULL', 'Influencer', 'NULL', 'NULL', 'NULL'],
            ['Yolo', 125, 'NULL', '1-1-1900', 'NULL', 'Youtuber', 'NULL', 'NULL', 'NULL'],
            ['Nando', 125, 'NULL', '1-1-1900', 'NULL', 'Youtuber', 'NULL', 'NULL', 'NULL'],
            ['Sebastián Fernández', 125, 'NULL', '1-1-1900', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Big Ari', 125, 'NULL', '1-1-1900', 'NULL', 'Exparticipante GH', 'NULL', 'NULL', 'NULL'],
            ['Gaston Pauls', 125, 'NULL', '1-1-1900', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Daniel Hendler', 125, 'NULL', '1-1-1900', 'NULL', 'Actor/Actriz, Director/a', 'NULL', 'NULL', 'NULL'],
            ['Chapu Nocioni', 45, 'NULL', '30-11-1979', 'NULL', 'Exbasquetbolista', 'NULL', 'NULL', 'NULL'],
            ['Franco Pisso', 30, 'NULL', '13-2-1994', 'NULL', 'Youtuber', 'NULL', 'NULL', 'NULL'],
            ['Juanita Groisman', 28, 'NULL', '6-8-1996', 'NULL', 'Twittero/a', 'NULL', 'NULL', 'NULL'],
            ['La Cobra', 26, 'NULL', '8-9-1998', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Mariano Martinez', 46, 'NULL', '5-12-1978', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Nachoide', 24, 'NULL', '24-5-2000', 'NULL', 'Twittero/a', 'NULL', 'NULL', 'NULL'],
            ['Sofi Martinez', 31, 'NULL', '7-5-1993', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Los Caballeros de la Quema', 125, 'NULL', '1-1-1900', 'NULL', 'Grupo Musical', 'NULL', 'NULL', 'NULL'],
            ['Nati Jota', 30, 'NULL', '26-5-1994', 'NULL', 'Influencer, Periodista', 'NULL', 'NULL', 'NULL'],
            ['Turco García', 61, 'NULL', '24-8-1963', 'NULL', 'Exfutbolista', 'NULL', 'NULL', 'NULL'],
            ['Caro Vazquez', 31, 'NULL', '29-4-1993', 'NULL', 'Jugadora Esports (FIFA)', 'NULL', 'NULL', 'NULL'],
            ['Mati Pellicioni', 38, 'NULL', '13-5-1986', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Mario Pergolini', 60, 'NULL', '3-7-1964', 'NULL', 'Presentador/a, Empresario/a', 'NULL', 'NULL', 'NULL'],
            ['Santi Korovsky', 39, 'NULL', '26-2-1985', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Augusto Batalla', 28, 'NULL', '30-4-1996', 'NULL', 'Futbolista', 'NULL', 'NULL', 'NULL'],
            ['Kapanga', 125, 'NULL', '1-1-1900', 'NULL', 'Grupo Musical', 'NULL', 'NULL', 'NULL'],
            ['Juanse', 62, 'NULL', '3-6-1962', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Santi Motorizado', 44, 'NULL', '19-5-1980', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Trinche Dardik', 26, 'NULL', '24-12-1998', 'NULL', 'Comediante', 'NULL', 'NULL', 'NULL'],
            ['Fernando Signorini', 74, 'NULL', '7-12-1950', 'NULL', 'Preparador Físico', 'NULL', 'NULL', 'NULL'],
            ['BM', 25, 'NULL', '27-8-1999', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Laureano Staropoli', 31, 'NULL', '27-2-1993', 'NULL', 'Luchador MMA', 'NULL', 'NULL', 'NULL'],
            ['Mariano Peluffo', 53, 'NULL', '1-4-1971', 'NULL', 'Conductor/a', 'NULL', 'NULL', 'NULL'],
            ['Nancy Dupláa', 55, 'NULL', '3-12-1969', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Rodolfo De Paoli', 46, 'NULL', '26-10-1978', 'NULL', 'Relator, Director Técnico', 'NULL', 'NULL', 'NULL'],
            ['Maru Botana', 56, 'NULL', '17-8-1968', 'NULL', 'Cocinero/a', 'NULL', 'NULL', 'NULL'],
            ['Bizarrap', 26, 'NULL', '29-8-1998', 'NULL', 'Productor Musical', 'NULL', 'NULL', 'NULL'],
            ['Jorgito Porcel Jr', 125, 'NULL', '1-1-1900', 'NULL', 'Personalidad de internet', 'NULL', 'NULL', 'NULL'],
            ['Gabriel Schultz', 58, 'NULL', '21-7-1966', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Acru', 27, 'NULL', '4-6-1997', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Julio Leiva', 46, 'NULL', '3-4-1978', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Esteban Lamothe', 47, 'NULL', '30-4-1977', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Coscu', 33, 'NULL', '3-8-1991', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Juanchi Baleiron', 59, 'NULL', '11-3-1965', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Natalie Perez', 38, 'NULL', '4-11-1986', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Maravilla Martinez', 49, 'NULL', '21-2-1975', 'NULL', 'Exboxeador', 'NULL', 'NULL', 'NULL'],
            ['Laucha (Locos x el Asado)', 125, 'NULL', '1-1-1900', 'NULL', 'Cocinero', 'NULL', 'NULL', 'NULL'],
            ['Luis Scola', 44, 'NULL', '30-4-1980', 'NULL', 'Exbasquetbolista', 'NULL', 'NULL', 'NULL'],
            ['Pimpeano', 26, 'NULL', '5-2-1998', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Joaco Lopez', 27, 'NULL', '23-7-1997', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Charo Lopez', 44, 'NULL', '6-5-1980', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Frankkaster', 27, 'NULL', '17-4-1997', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Esteban Edul', 40, 'NULL', '10-11-1984', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Flavio Azzaro', 39, 'NULL', '12-11-1985', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Duka', 63, 'NULL', '27-1-1961', 'NULL', 'Dirigente Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Soy Rada', 41, 'NULL', '15-9-1983', 'NULL', 'Mago, Comediante', 'NULL', 'NULL', 'NULL'],
            ['Fabricio Oberto', 49, 'NULL', '21-3-1975', 'NULL', 'Exbasquetbolista', 'NULL', 'NULL', 'NULL'],
            ['Sebastián Wainraich', 50, 'NULL', '23-5-1974', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Mariano Zabaleta', 46, 'NULL', '28-2-1978', 'NULL', 'Extenista', 'NULL', 'NULL', 'NULL'],
            ['Juli Savioli', 22, 'NULL', '24-1-2002', 'NULL', 'Influencer', 'NULL', 'NULL', 'NULL'],
            ['Facundo Sava', 50, 'NULL', '7-3-1974', 'NULL', 'Exfutbolista, Director Técnico (Fútbol)', 'NULL', 'NULL', 'NULL'],
            ['Benito SDR', 26, 'NULL', '17-10-1998', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Miguel Simón', 59, 'NULL', '23-7-1965', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Emiliano Brancciari', 47, 'NULL', '28-10-1977', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Franco Colapinto', 21, 'NULL', '27-5-2003', 'NULL', 'Piloto de F1', 'NULL', 'NULL', 'NULL'],
            ['Chanchi Estevez', 47, 'NULL', '2-6-1977', 'NULL', 'Exfutbolista', 'NULL', 'NULL', 'NULL'],
            ['Seleneitor', 26, 'NULL', '13-12-1998', 'NULL', 'Influencer', 'NULL', 'NULL', 'NULL'],
            ['Manuel Burak', 125, 'NULL', '1-1-1900', 'NULL', 'Productor/a', 'NULL', 'NULL', 'NULL'],
            ['Iván Schargrodsky', 35, 'NULL', '17-3-1989', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Mauro Albarracin', 27, 'NULL', '31-5-1997', 'NULL', 'Youtuber', 'NULL', 'NULL', 'NULL'],
            ['YSY A', 26, 'NULL', '12-7-1998', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Alfredo Casero', 62, 'NULL', '12-11-1962', 'NULL', 'Actor/Actriz, Comediante', 'NULL', 'NULL', 'NULL'],
            ['Martin Kohan', 125, 'NULL', '1-1-1900', 'NULL', 'Escritor/a', 'NULL', 'NULL', 'NULL'],
            ['Cristian Castro', 50, 'NULL', '8-12-1974', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Nicki Nicole', 24, 'NULL', '25-8-2000', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Sebastian Porrini', 125, 'NULL', '1-1-1900', 'NULL', 'Docente, Escritor/a', 'NULL', 'NULL', 'NULL'],
            ['Axel', 48, 'NULL', '1-1-1977', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Campi', 55, 'NULL', '10-2-1969', 'NULL', 'Comediante', 'NULL', 'NULL', 'NULL'],
            ['Donato de Santis', 60, 'NULL', '5-3-1964', 'NULL', 'Cocinero/a', 'NULL', 'NULL', 'NULL'],
            ['Karina', 38, 'NULL', '30-1-1986', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Emiliano Coroniti', 41, 'NULL', '15-2-1983', 'NULL', 'Empresario/a, Conductor/a', 'NULL', 'NULL', 'NULL'],
            ['Ariel Cristofalo', 125, 'NULL', '1-1-1900', 'NULL', 'Perdiosita Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Julio Lamas', 60, 'NULL', '9-6-1964', 'NULL', 'Director técnico de basquet', 'NULL', 'NULL', 'NULL'],
            ['Tuli Acosta', 23, 'NULL', '20-6-2001', 'NULL', 'Influencer, Bailarin/a, Cantante', 'NULL', 'NULL', 'NULL'],
            ['Chapu Martinez', 30, 'NULL', '3-5-1994', 'NULL', 'Influencer', 'NULL', 'NULL', 'NULL'],
            ['C0ker', 27, 'NULL', '10-7-1997', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Khea', 24, 'NULL', '13-4-2000', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Asan', 24, 'NULL', '10-3-2000', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Juan Minujin', 49, 'NULL', '20-5-1975', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Gastón Recondo', 51, 'NULL', '4-5-1973', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Puma Goity', 64, 'NULL', '23-10-1960', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Marcelo Toscano', 125, 'NULL', '1-1-1900', 'NULL', 'Abogado/a, DJ', 'NULL', 'NULL', 'NULL'],
            ['Araceli Gonzalez', 57, 'NULL', '19-6-1967', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Martín Cirio', 40, 'NULL', '13-6-1984', 'NULL', 'Youtuber', 'NULL', 'NULL', 'NULL'],
            ['Wos', 26, 'NULL', '23-1-1998', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Cumbio', 33, 'NULL', '6-5-1991', 'NULL', 'Flogger', 'NULL', 'NULL', 'NULL'],
            ['Lalo Maradona', 58, 'NULL', '29-11-1966', 'NULL', 'Exfutbolista, Director Técnico (Fútbol)', 'NULL', 'NULL', 'NULL'],
            ['Mateo Sujatovich', 33, 'NULL', '18-1-1991', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Duende Pablo', 38, 'NULL', '16-12-1986', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Tobías Medrano (La T y la M)', 125, 'NULL', '1-1-1900', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Matías Rapen (La T y la M)', 125, 'NULL', '1-1-1900', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['De La Ghetto', 40, 'NULL', '17-9-1984', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Ca7riel', 31, 'NULL', '5-12-1993', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Paco Amoroso', 31, 'NULL', '17-8-1993', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Marcos Giles', 125, 'NULL', '1-1-1900', 'NULL', 'Comediante', 'NULL', 'NULL', 'NULL'],
            ['Zaina', 21, 'NULL', '4-9-2003', 'NULL', 'Freestyler', 'NULL', 'NULL', 'NULL'],
            ['Morena Beltrán', 25, 'NULL', '29-1-1999', 'NULL', 'Periodista Deportiva', 'NULL', 'NULL', 'NULL'],
            ['Yeti Bruta Cocina', 38, 'NULL', '11-2-1986', 'NULL', 'Cocinero/a', 'NULL', 'NULL', 'NULL'],
            ['Mariano Pavone', 42, 'NULL', '27-5-1982', 'NULL', 'Exfutbolista', 'NULL', 'NULL', 'NULL'],
            ['Guillermo Lopez', 125, 'NULL', '1-1-1900', 'NULL', 'Conductor/a', 'NULL', 'NULL', 'NULL'],
            ['Ibai Llanos', 29, 'NULL', '26-3-1995', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Nachito Saralegui', 32, 'NULL', '1-4-1992', 'NULL', 'Comediante', 'NULL', 'NULL', 'NULL'],
            ['Maligno Torres', 29, 'NULL', '28-3-1995', 'NULL', 'Ciclista', 'NULL', 'NULL', 'NULL'],
            ['Marcelo Benedetto', 58, 'NULL', '6-8-1966', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Cofla24cm', 125, 'NULL', '1-1-1900', 'NULL', 'Actor Porno', 'NULL', 'NULL', 'NULL'],
            ['Spreen', 24, 'NULL', '11-10-2000', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Lucas Blondel', 28, 'NULL', '14-9-1996', 'NULL', 'Futbolista', 'NULL', 'NULL', 'NULL'],
            ['El Zar de las Finanzas', 37, 'NULL', '26-5-1987', 'NULL', 'Economista', 'NULL', 'NULL', 'NULL'],
            ['Emilio Moreira (Tiempo de Videojuegos)', 45, 'NULL', '15-10-1979', 'NULL', 'Comediante', 'NULL', 'NULL', 'NULL'],
            ['Juan Ruffo', 125, 'NULL', '1-1-1900', 'NULL', 'Productor/a, Conductor/a', 'NULL', 'NULL', 'NULL'],
            ['Tomas Mazza', 24, 'NULL', '16-4-2000', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Gustavo Fernández', 30, 'NULL', '21-1-1994', 'NULL', 'Tenista', 'NULL', 'NULL', 'NULL'],
            ['Pablo Granados', 59, 'NULL', '11-9-1965', 'NULL', 'Comediante, Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Federico Coria', 32, 'NULL', '9-3-1992', 'NULL', 'Tenista', 'NULL', 'NULL', 'NULL'],
            ['Pablo Kenny', 125, 'NULL', '1-1-1900', 'NULL', 'Productor/a', 'NULL', 'NULL', 'NULL'],
            ['Pablo Migliore', 42, 'NULL', '27-1-1982', 'NULL', 'Exfutbolista', 'NULL', 'NULL', 'NULL'],
            ['Cesar Luis Merlo', 125, 'NULL', '1-1-1900', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Mike la Maquina del Mal', 31, 'NULL', '31-7-1993', 'NULL', 'Influencer', 'NULL', 'NULL', 'NULL'],
            ['Will Futbolito', 24, 'NULL', '29-6-2000', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Skone', 35, 'NULL', '27-12-1989', 'NULL', 'Freestyler', 'NULL', 'NULL', 'NULL'],
            ['Beto Casella', 64, 'NULL', '29-3-1960', 'NULL', 'Periodista', 'NULL', 'NULL', 'NULL'],
            ['Walter Nelson', 74, 'NULL', '16-8-1950', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Alejandro Fabbri', 68, 'NULL', '28-4-1956', 'NULL', 'Periodista Deportivo', 'NULL', 'NULL', 'NULL'],
            ['Marti Benza', 24, 'NULL', '26-8-2000', 'NULL', 'Youtuber', 'NULL', 'NULL', 'NULL'],
            ['Nazareno Casero', 125, 'NULL', '1-1-1900', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Neo Pistea', 30, 'NULL', '5-10-1994', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Caro Pardiaco', 125, 'NULL', '1-1-1900', 'NULL', 'Influencer', 'NULL', 'NULL', 'NULL'],
            ['Nico Vazquez', 47, 'NULL', '12-6-1977', 'NULL', 'Actor/Actriz', 'NULL', 'NULL', 'NULL'],
            ['Furia', 33, 'NULL', '18-3-1991', 'NULL', 'Exparticipante de GH', 'NULL', 'NULL', 'NULL'],
            ['Diego Leuco', 35, 'NULL', '16-10-1989', 'NULL', 'Periodista, Conductor/a', 'NULL', 'NULL', 'NULL'],
            ['Gustavo Costas', 61, 'NULL', '28-2-1963', 'NULL', 'Exfutbolista, Director Técnico (Fútbol)', 'NULL', 'NULL', 'NULL'],
            ['Stiffy', 125, 'NULL', '1-1-1900', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['AgustinFortnite2008', 125, 'NULL', '1-1-1900', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Turrobaby', 17, 'NULL', '12-2-2007', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Zell', 19, 'NULL', '25-2-2005', 'NULL', 'Músico/a', 'NULL', 'NULL', 'NULL'],
            ['Trueno', 125, 'NULL', '1-1-1900', 'NULL', 'Freestyler, Músico/a', 'NULL', 'NULL', 'NULL'],
            ['ManuelaQM', 125, 'NULL', '1-1-1900', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Viruzz', 125, 'NULL', '1-1-1900', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL'],
            ['Guanyar', 125, 'NULL', '1-1-1900', 'NULL', 'Streamer', 'NULL', 'NULL', 'NULL']
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
     * @return array<array{string, string}>
     */
    private function getEdicionData(): array {
        return [
            // $edicionData = [$nombre, $tipo];
            ['Estudio 2022', 'programa'],
            ['Show en vivo', 'programa'],
            ['Mundial - Qatar 2022', 'programa'],
            ['Estudio 2023', 'programa'],
            ['Ciudad Emergente', 'programa'],
            ['España 2023', 'programa'],
            ['Primavera en Vicente Lopez', 'programa'],
            ['Estudio Mirame y no me toques', 'programa'],
            ['Evento especial', 'programa'],
            ['Vlog Londres - Final FA Cup 2022 | Luquitas y Alfre', 'vlog'],
            ['Vlog Qatar - Mundial 2022', 'vlog'],
            ['Vlog Qatar - Mundial 2022 | Germán', 'vlog'],
            ['Vlog Estambul - Final Champions 2023 | Luquitas y Alfre', 'vlog'],
            ['Vlog España - Velada del año 2023', 'vlog'],
            ['Vlog España - Velada del año 2023 | Germán', 'vlog'],
            ['Vlog Francia - Mundial de rugby 2023 | Alfre', 'vlog'],
            ['Vlog España - La Liga Experience | Alfre', 'vlog'],
            ['Vlog Japón | Luquitas', 'vlog'],
            ['Vlog Estados Unidos - Final Superbowl 2024 | Luquitas', 'vlog'],
            ['Vlog Londres - Final Champions 2024 | Luquitas y Alfre', 'vlog'],
            ['Vlog Roma | Luquitas', 'vlog'],
            ['Vlog EEUU y España - Copa América y Velada del año 2024', 'vlog'],
            ['Vlog EEUU y España - Copa América y Velada del año 2024 | Germán', 'vlog'],
            ['Vlog EEUU - Copa América 2024 | Alfre', 'vlog'],
            ['Vlog Berlín y Paris | Alfre', 'vlog'],
            ['Vlog París - Juegos Olimpicos 2024', 'vlog'],
            ['Vlog México - Luquitas en la F1', 'vlog'],
            ['Párense de Manos I', 'pdm'],
            ['Párense de Manos II', 'pdm'],
            ['Estudio 2024', 'programa'],
            ['Copa América - Estados Unidos 2024', 'programa'],
            ['España 2024', 'programa'],
            ['Personajes del año 2024', 'programa']
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