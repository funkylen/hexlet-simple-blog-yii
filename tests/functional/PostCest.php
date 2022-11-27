<?php

namespace functional;

use app\fixtures\PostFixture;
use app\models\Post;
use FunctionalTester;
use yii\helpers\Url;

class PostCest
{
    public function _fixtures(): array
    {
        return [
            'posts' => [
                'class' => PostFixture::class,
                'dataFile' => codecept_data_dir('posts.php'),
            ],
        ];
    }

    public function visitPostIndexPage(FunctionalTester $I): void
    {
        $I->amOnRoute('post/index');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Posts', 'h1');

        $posts = $I->grabFixture('posts');

        foreach ($posts as $post) {
            $I->see($post['title']);
        }
    }

    public function createPostFromIndexPage(FunctionalTester $I): void
    {
        $I->amOnRoute('post/index');

        $I->click('Create Post');

        $I->fillField('Post[title]', 'Title');
        $I->fillField('Post[content]', 'Content');

        $I->click('Save');

        $I->seeResponseCodeIsSuccessful();

        $I->seeRecord(Post::class, [
            'title' => 'Title',
            'content' => 'Content',
        ]);
    }

    public function createPost(FunctionalTester $I): void
    {
        $I->amOnRoute('post/create');

        $I->submitForm('form', [
            'Post[title]' => 'Title',
            'Post[content]' => 'Content',
        ]);

        $I->seeResponseCodeIsSuccessful();

        $I->seeRecord(Post::class, [
            'title' => 'Title',
            'content' => 'Content',
        ]);
    }

    public function visitUpdatePostPage(FunctionalTester $I): void
    {
        $postId = 20000;

        $I->amOnRoute('post/update', ['id' => $postId]);

        $I->seeResponseCodeIsSuccessful();

        $post = $I->grabFixture('posts', $postId);

        $I->seeInField('Post[title]', $post->title);
        $I->seeInField('Post[content]', $post->content);
    }

    public function updatePost(FunctionalTester $I): void
    {
        $postId = 20000;

        $I->amOnRoute('post/update', ['id' => $postId]);

        $I->submitForm('form', [
            'Post[title]' => 'Updated Title',
        ]);

        $I->seeResponseCodeIsSuccessful();

        $I->seeRecord(Post::class, [
            'id' => $postId,
            'title' => 'Updated Title',
        ]);
    }

    public function deletePost(FunctionalTester $I): void
    {
        $uri = Url::to([
            '/post/delete',
            'id' => 10000,
        ]);

        $I->sendAjaxPostRequest($uri);

        $I->dontSeeRecord(Post::class, ['id' => 10000]);
    }

    public function createPostWithInvalidValues(FunctionalTester $I): void
    {
        $I->amOnRoute('post/create');

        $I->submitForm('form', [
        ]);

        $I->dontSeeRecord(Post::class, [
            'title' => '',
        ]);
    }
}
