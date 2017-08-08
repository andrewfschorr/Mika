<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->make();
    }
    
    public function testOptions()
    {
        $this->user->setOption('foo', 'bar');
        $this->user->setOptions([
            'bar' => 99,
            'angels' => 69
        ]);
        $this->assertEquals($this->user->getOption('foo'), 'bar');
        $this->assertEquals($this->user->getOption('bar'), 99);
        $this->assertEquals($this->user->getOption('angels'), 69);
        
        $this->user->deleteOption('angels');
        $this->assertEquals($this->user->getOption('angels'), null);
        $this->user->deleteOptions(['foo', 'bar']);
        $this->assertEquals($this->user->getOption('foo'), null);
        $this->assertEquals($this->user->getOption('bar'), null);
        
        $this->user->deleteOption('dfsf');
        $this->assertEquals($this->user->getOption('dfsf'), null);

    }

    public function testIgAttributes()
    {
        $this->user->setIg('id', 12345);
        $this->user->setIgs([
            'id' => 12345,
            'username' => 'frankeliuspoopie',
        ]);
        $this->user->setIg('thingey', 12345);
        $this->assertEquals($this->user->getIg('thingey'), null);
    }
}

/*
 * $user->setOption('foo', 'bar');
 * $user->setOptions([
 *  'thing' => 'tihng t00'
 * ]);
 * $user->options['foo']
 * $user->deleteOption('foo');
 * $user->deleteOptions(['a', 'b', 'c']);
 * $user->getOption('foo');
 *
 * $user->setIg('id', 12345);
 * $user->setIg([
 *     'id' => 12345
 *      'username' => frankeliuspoopie
 * ]);
 *
 * $user->getIg('name');
 * $user->getOption('foo');
 */