<?php

namespace App\Test\Controller;

use App\Entity\Cafeteria;
use App\Repository\CafeteriaRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CafeteriaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CafeteriaRepository $repository;
    private string $path = '/cafeteria/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Cafeteria::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cafeterium index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'cafeterium[nombre]' => 'Testing',
            'cafeterium[descripcion]' => 'Testing',
            'cafeterium[direccion]' => 'Testing',
            'cafeterium[precioCafeConLeche]' => 'Testing',
            'cafeterium[parque]' => 'Testing',
        ]);

        self::assertResponseRedirects('/cafeteria/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cafeteria();
        $fixture->setNombre('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setDireccion('My Title');
        $fixture->setPrecioCafeConLeche('My Title');
        $fixture->setParque('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cafeterium');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cafeteria();
        $fixture->setNombre('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setDireccion('My Title');
        $fixture->setPrecioCafeConLeche('My Title');
        $fixture->setParque('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'cafeterium[nombre]' => 'Something New',
            'cafeterium[descripcion]' => 'Something New',
            'cafeterium[direccion]' => 'Something New',
            'cafeterium[precioCafeConLeche]' => 'Something New',
            'cafeterium[parque]' => 'Something New',
        ]);

        self::assertResponseRedirects('/cafeteria/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getDescripcion());
        self::assertSame('Something New', $fixture[0]->getDireccion());
        self::assertSame('Something New', $fixture[0]->getPrecioCafeConLeche());
        self::assertSame('Something New', $fixture[0]->getParque());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Cafeteria();
        $fixture->setNombre('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setDireccion('My Title');
        $fixture->setPrecioCafeConLeche('My Title');
        $fixture->setParque('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/cafeteria/');
    }
}
