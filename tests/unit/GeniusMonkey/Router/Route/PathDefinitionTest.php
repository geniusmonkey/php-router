<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 2/25/17
 * Time: 12:54 PM
 */

namespace GeniusMonkey\Router\Route;


use PHPUnit\Framework\TestCase;

class PathDefinitionTest extends TestCase
{


    public function testMatches()
    {
        $path = new PathDefinition();

        $path->setPath("/");
        self::assertTrue($path->matches(new MatchContext("/")));
        self::assertTrue($path->matches(new MatchContext("/test")));
        self::assertTrue($path->matches(new MatchContext("/test/123")));
        self::assertTrue($path->matches(new MatchContext("/test/123/second")));

        $path->setPath("/test");
        self::assertFalse($path->matches(new MatchContext("/")));
        self::assertTrue($path->matches(new MatchContext("/test")));
        self::assertTrue($path->matches(new MatchContext("/test/")));
        self::assertTrue($path->matches(new MatchContext("/test/123")));
        self::assertTrue($path->matches(new MatchContext("/test/123/second")));

        $path->setPath("/test/");
        self::assertFalse($path->matches(new MatchContext("/")));
        self::assertTrue($path->matches(new MatchContext("/test")));
        self::assertTrue($path->matches(new MatchContext("/test/")));
        self::assertTrue($path->matches(new MatchContext("/test/123")));
        self::assertTrue($path->matches(new MatchContext("/test/123/second")));

        $path->setPath("/test/123");
        self::assertFalse($path->matches(new MatchContext("/")));
        self::assertFalse($path->matches(new MatchContext("/test")));
        self::assertTrue($path->matches(new MatchContext("/test/123")));
        self::assertTrue($path->matches(new MatchContext("/test/123/second")));


        $path->setPath("/test/:id");
        self::assertFalse($path->matches(new MatchContext("/")));
        self::assertFalse($path->matches(new MatchContext("/test")));
        self::assertTrue($path->matches(new MatchContext("/test/123")));
        self::assertTrue($path->matches(new MatchContext("/test/123/second")));


        $path->setPath("/test/:id/second");
        self::assertFalse($path->matches(new MatchContext("/")));
        self::assertFalse($path->matches(new MatchContext("/test")));
        self::assertFalse($path->matches(new MatchContext("/test/123")));
        self::assertTrue($path->matches(new MatchContext("/test/123/second")));
    }

    public function testMatchesAndCapturesPathParams()
    {
        $path = new PathDefinition();
        $path->setPath("/test/:id/second");
        $context = new MatchContext("/test/123/second");

        self::assertTrue($path->matches($context));
        self::assertTrue($context->isMatched());
        self::assertEquals("123", $context->getPathParameters()['id']);
    }


    public function testMatchesAndGetSubPath()
    {
        $path = new PathDefinition();
        $path->setPath("/test/:id");
        $context = new MatchContext("/test/123/second");

        self::assertTrue($path->matches($context));
        self::assertTrue($context->isMatched());
        self::assertEquals("123", $context->getPathParameters()['id']);
        self::assertEquals("second", $context->getSubPath());
    }


}
