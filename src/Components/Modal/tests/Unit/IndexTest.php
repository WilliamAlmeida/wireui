<?php

namespace WireUi\Components\Modal\tests\Unit;

use WireUi\Components\Modal\Index as Modal;
use WireUi\Components\Modal\WireUi\{Align, Blur, Type, Width};

beforeEach(function () {
    $this->component = (new Modal())->withName('modal');
});

test('it should have array properties', function () {
    $packs = $this->invokeProperty($this->component, 'packs');

    expect($packs)->toBe(['align', 'blur', 'width', 'type']);

    $props = $this->invokeProperty($this->component, 'props');

    expect($props)->toBe([
        'name'       => null,
        'show'       => false,
        'spacing'    => null,
        'z-index'    => null,
        'blurless'   => false,
        'persistent' => false,
    ]);
});

test('it should have properties in component', function () {
    $this->runWireUiComponent($this->component);

    expect($this->component)->toHaveProperties([
        // Props
        'name',
        'show',
        'zIndex',
        'spacing',
        'blurless',
        'persistent',
        // Packs
        'blur',
        'type',
        'align',
        'width',
        'blurClasses',
        'typeClasses',
        'alignClasses',
        'widthClasses',
    ]);

    expect($this->component->show)->toBeFalse();
    expect($this->component->blurless)->toBeFalse();
    expect($this->component->persistent)->toBeFalse();
});

test('it should set a custom name and persistent as true in component', function () {
    $this->setAttributes($this->component, [
        'persistent' => true,
        'name'       => $name = fake()->slug(),
    ]);

    $this->runWireUiComponent($this->component);

    expect($this->component->name)->toBe($name);
    expect($this->component->persistent)->toBeTrue();
});

test('it should set random align in component', function () {
    $pack = $this->getRandomPack(Align::class);

    $this->setAttributes($this->component, [
        'align' => $align = data_get($pack, 'key'),
    ]);

    $this->runWireUiComponent($this->component);

    $class = data_get($pack, 'class');

    expect($this->component->align)->toBe($align);
    expect($this->component->alignClasses)->toBe($class);

    expect('<x-wui:modal :$align />')->render(compact('align'))->toContain($class);
});

test('it should set random blur in component', function () {
    $pack = $this->getRandomPack(Blur::class);

    $this->setAttributes($this->component, [
        'blur' => $blur = data_get($pack, 'key'),
    ]);

    $this->runWireUiComponent($this->component);

    $class = data_get($pack, 'class');

    expect($this->component->blur)->toBe($blur);
    expect($this->component->blurClasses)->toBe($class);

    expect('<x-wui:modal :$blur />')->render(compact('blur'))->toContain($class);
});

test('it should set random width in component', function () {
    $pack = $this->getRandomPack(Width::class);

    $this->setAttributes($this->component, [
        'width' => $width = data_get($pack, 'key'),
    ]);

    $this->runWireUiComponent($this->component);

    $class = data_get($pack, 'class');

    expect($this->component->width)->toBe($width);
    expect($this->component->widthClasses)->toBe($class);

    expect('<x-wui:modal :$width />')->render(compact('width'))->toContain($class);
});

test('it should set random type in component', function () {
    $pack = $this->getRandomPack(Type::class);

    $this->setAttributes($this->component, [
        'z-index' => $zIndex = null,
        'type'    => $type   = data_get($pack, 'key'),
    ]);

    $this->runWireUiComponent($this->component);

    $class = data_get($pack, 'class');

    expect($this->component->type)->toBe($type);
    expect($this->component->typeClasses)->toBe($class);

    expect('<x-wui:modal :$type :$zIndex />')->render(compact('type', 'zIndex'))->toContain(...[
        data_get($pack, 'class.z-index'),
        data_get($pack, 'class.spacing'),
    ]);
});
