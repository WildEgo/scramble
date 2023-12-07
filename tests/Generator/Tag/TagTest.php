<?php

use Illuminate\Support\Facades\Route as RouteFacade;

it('documents tags based on phpdoc param', function () {
    $openApiDocument = generateForRoute(function () {
        return RouteFacade::get('api/test', [ManualTagDocumentationTestController::class, 'a'])->name('someNameOfRoute');
    });

    expect($openApiDocument['paths']['/test']['get'])
        ->toHaveKey('tags', ['testTag', 'ManualTagDocumentationTest']);
});
class ManualTagDocumentationTestController extends \Illuminate\Routing\Controller
{
    /**
     * @tags testTag
     */
    public function a(): Illuminate\Http\Resources\Json\JsonResource
    {
        return $this->unknown_fn();
    }
}

it('disable auto controller tags', function () {
    config()->set('scramble.disable_controller_tag', true);
    $openApiDocument = generateForRoute(function () {
        return RouteFacade::get('api/test', [DisableControllerTagDocumentationTestController::class, 'a'])->name('someNameOfRoute');
    });

    expect($openApiDocument['paths']['/test']['get'])
        ->toHaveKey('tags', ['testTag']);
});
class DisableControllerTagDocumentationTestController extends \Illuminate\Routing\Controller
{
    /**
     * @tags testTag
     */
    public function a(): Illuminate\Http\Resources\Json\JsonResource
    {
        return $this->unknown_fn();
    }
}

it('documents tags multiple tags based on inline phpdoc param', function () {
    $openApiDocument = generateForRoute(function () {
        return RouteFacade::get('api/test', [ManualInlineTagsDocumentationTestController::class, 'a'])->name('someNameOfRoute');
    });

    expect($openApiDocument['paths']['/test']['get'])
        ->toHaveKey('tags', ['testTag', 'testTag2', 'ManualInlineTagsDocumentationTest']);
});
class ManualInlineTagsDocumentationTestController extends \Illuminate\Routing\Controller
{
    /**
     * @tags testTag,testTag2
     */
    public function a(): Illuminate\Http\Resources\Json\JsonResource
    {
        return $this->unknown_fn();
    }
}

it('documents tags multiple tags based on multiline phpdoc param', function () {
    $openApiDocument = generateForRoute(function () {
        return RouteFacade::get('api/test', [ManualMultilineTagsDocumentationTestController::class, 'a'])->name('someNameOfRoute');
    });

    expect($openApiDocument['paths']['/test']['get'])
        ->toHaveKey('tags', ['testTag', 'testTag2', 'ManualMultilineTagsDocumentationTest']);
});
class ManualMultilineTagsDocumentationTestController extends \Illuminate\Routing\Controller
{
    /**
     * @tags testTag
     * @tags testTag2
     */
    public function a(): Illuminate\Http\Resources\Json\JsonResource
    {
        return $this->unknown_fn();
    }
}
