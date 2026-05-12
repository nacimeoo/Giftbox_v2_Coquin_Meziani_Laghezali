<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* index.twig */
class __TwigTemplate_a280bef161dc19c4e6f6d6cd7887c939 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <title>Gift App</title>
</head>
<body>
    ";
        // line 8
        yield from $this->load("header.twig", 8)->unwrap()->yield($context);
        // line 9
        yield "    ";
        yield from $this->load("nav.twig", 9)->unwrap()->yield($context);
        // line 10
        yield "
    <main>
        ";
        // line 12
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 14
        yield "    </main>

    ";
        // line 16
        yield from $this->load("footer.twig", 16)->unwrap()->yield($context);
        // line 17
        yield "</body>
</html>";
        yield from [];
    }

    // line 12
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 13
        yield "        ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "index.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  82 => 13,  75 => 12,  69 => 17,  67 => 16,  63 => 14,  61 => 12,  57 => 10,  54 => 9,  52 => 8,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "index.twig", "C:\\xampp\\htdocs\\Giftbox_Coquin_Meziani_Laghezali\\gift.appli\\src\\views\\index.twig");
    }
}
