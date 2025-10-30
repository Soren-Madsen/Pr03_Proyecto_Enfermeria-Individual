<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class NurseControllerTest extends WebTestCase
{
    private string $dataFile;
    private ?string $backupContents = null;

    protected function setUp(): void
    {
        // Use project root relative to tests directory to avoid booting kernel here
        $this->dataFile = dirname(__DIR__) . '/nurses.json';

        // Backup original file if exists
        if (file_exists($this->dataFile)) {
            $this->backupContents = file_get_contents($this->dataFile);
        }

        // Write test data
        $testData = [
            [
                'name' => 'Ana',
                'username' => 'afernandez',
                'password' => 'pass789'
            ],
            [
                'name' => 'Carlos',
                'username' => 'cgarcia',
                'password' => 'pass123'
            ]
        ];

        file_put_contents($this->dataFile, json_encode($testData));
    }

    protected function tearDown(): void
    {
        // Restore backup or remove test file
        if ($this->backupContents !== null) {
            file_put_contents($this->dataFile, $this->backupContents);
        } else {
            @unlink($this->dataFile);
        }

        parent::tearDown();
    }

    public function testFindExistingNurse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/nurse/name/Ana');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('nurse', $data);
        $this->assertSame('Ana', $data['nurse']['name']);
    }

    public function testFindNonExistingNurse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/nurse/name/NoExiste');

        $this->assertSame(404, $client->getResponse()->getStatusCode());
    }
}
