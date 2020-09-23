<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\News;
use App\Models\User;

class SduiTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // Basic test to check the test workings
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // Test function to check the working of the News Index function/page.
    // Cheking with Status and Response Json structure
    public function testIndexPage(){
        // creating dummy news object
        $news = News::factory()->create();

        $response = $this->get('/news');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'title',
                'content'
            ]
        ]);
    }

    // Test function to check the working of the News Create function/page.
    // Cheking with Status
    public function testCreatePage(){

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/news/create');
        $response->assertStatus(200);
    }

    // Test function to check the working of the News Store function/page.
    // Sending dummy news data with $data
    // Cheking with Status and Response of DB query response
    public function testStore(){
        $user = User::factory()->create();
        $news = News::factory()->create();
        $data = [
            'title' => $news->title,
            'content' => $news->content
        ];
        $response = $this->actingAs($user)->post('/news',$data);
        $response->assertStatus(200);
        $response->assertSee(true);
    }

    // Test function to check the working of the News Show function/page.
    // Sending News id to get specific news
    // Cheking with Status and Response Json structure
    public function testShowPage(){

        $news = News::factory()->create();

        $response = $this->get("/news/".$news->id);
        $response->assertStatus(200);
        $response->assertSee($news->id);
        $response->assertSee($news->title);
    }

    // Test function to check the working of the News Edit function/page.
    // Creating news with the user_id same as new user created on top of function to get access to specific edit function
    // Cheking with Status, DB response and Response Json contains
    public function testEditPage(){
        $user = User::factory()->create();
        $news = News::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get("/news/".$news->id."/edit");
        $response->assertStatus(200);
        $response->assertSee(true);
        $response->assertSee($news->id);
        $response->assertSee($news->title);
    }

    // Test function to check the working of the News Update function/page.
    // Creating news with the user_id same as new user created on top of function to get access to specific edit function
    // Sending dummy news data to change the news details
    // Cheking with Status, DB response and Response Json contains
    public function testUpdate(){
        $user = User::factory()->create();
        $news = News::factory()->create([
            'user_id' => $user->id,
        ]);
        $data = [
            'title' => $news->title,
            'content' => $news->content
        ];
        $response = $this->actingAs($user)->put("/news/".$news->id ,$data);
        $response->assertStatus(200);
        $response->assertSee(true);
    }

    // Test function to check the working of the News Delete function/page.
    // Sending news id and user to delete specific news if that belongs to correct user.
    // Cheking with Status, DB response and Response Json contains
    public function testDestroy(){
        $user = User::factory()->create();
        $news = News::factory()->create();

        $response = $this->actingAs($user)->delete("/news/".$news->id, [
            'id' => $news->id,
         ]);
        $response->assertStatus(200);
        $response->assertSee(true);
    }
}
