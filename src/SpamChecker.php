<?php

declare(strict_types=1);

namespace App;

use App\Entity\Comment;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpamChecker
{
    private HttpClientInterface $client;
    private string $akismetKey;
    private string $endpoint;

    public function __construct(HttpClientInterface $client, string $akismetKey)
    {
        $this->client = $client;
        $this->akismetKey = $akismetKey;
        $this->endpoint = sprintf('https://%s.rest.akismet.com/1.1/comment-check', $akismetKey);
    }

    public function getSpamScore(Comment $comment, array $context): int
    {
        $response = $this->client->request('POST', $this->endpoint, [
           'body' => array_merge($context, [
               'blog' => 'localhost',
               'comment_type' > 'comment',
               'commment_author' => $comment->getAuthor(),
               'commment_author_email' => 'akismet-guaranteed-spam@example.com',
               'commment_content' => 'akismet-guaranteed-spam',
               'commment_date_gtm' => $comment->getCreatedAt()->format('c'),
               'blog_lang' => 'en',
               'blog_charset' => 'UTF-8',
               'is_test' => true,
               ]),
        ]);

        $headers = $response->getHeaders();

        if ('discard' === ($headers['x-akismet-pro-tip'][0] ?? '')) {
            return  2;
        }

        $content = $response->getContent();

        if (isset($headers['x-akismet-debug-help'][0])) {
            throw new \RuntimeException(sprintf('Unable to check for spam: %s (%s).', $content, $headers['x-akismet-debug-help'][0]));
        }

        return 'true' === $content ? 1 : 0;
    }
}
