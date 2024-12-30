<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Programa;
use Doctrine\ORM\EntityManagerInterface;

class YoutubeService {

    public string $apiKey;
    
    private $youtubeApiUrl = 'https://www.googleapis.com/youtube/v3/playlistItems';

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, string $apiKey) {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->apiKey = $apiKey;
    }

    public function getProgramasFromPlaylist(string $playlistId): array {
        $programas = [];
        $nextPageToken = null;
        
        do {
            $url = sprintf(
                '%s?part=snippet&playlistId=%s&maxResults=50&key=%s%s',
                $this->youtubeApiUrl,
                $playlistId,
                $this->apiKey,
                $nextPageToken ? '&pageToken=' . $nextPageToken : ''
            );

            try {
                $response = $this->httpClient->request('GET', $url);
                $data = $response->toArray();
            } catch (\Exception $e) {
                throw new \RuntimeException('Error al comunicarse con la API de YouTube: ' . $e->getMessage());
            }

            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $snippet = $item['snippet'];
                    $programa = new Programa();
                    $programa->setTitulo($snippet['title']);
                    $programa->setFecha(new \DateTime($snippet['publishedAt']));
                    $programa->setLinkYoutube('https://www.youtube.com/watch?v='.$snippet['resourceId']['videoId']);
                    $programa->setMiniatura($snippet['thumbnails']['medium']['url']);

                    array_unshift($programas, $programa);
                }
            }

            $nextPageToken = $data['nextPageToken'] ?? null;

        } while ($nextPageToken);

        return $programas;
    }
}