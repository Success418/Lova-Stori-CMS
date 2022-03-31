<?php
if (version_compare(PHP_VERSION, '5.4') < 0) {
    throw new \Exception('scssphp requires PHP 5.4 or above');
}

if (! class_exists('Leafo\ScssPhp\Version', false)) {
    include_once __DIR__ . '/scssphp/src/Base/Range.php';
    include_once __DIR__ . '/scssphp/src/Block.php';
    include_once __DIR__ . '/scssphp/src/Colors.php';
    include_once __DIR__ . '/scssphp/src/Compiler.php';
    include_once __DIR__ . '/scssphp/src/Compiler/Environment.php';
    include_once __DIR__ . '/scssphp/src/Exception/CompilerException.php';
    include_once __DIR__ . '/scssphp/src/Exception/ParserException.php';
    include_once __DIR__ . '/scssphp/src/Exception/RangeException.php';
    include_once __DIR__ . '/scssphp/src/Exception/ServerException.php';
    include_once __DIR__ . '/scssphp/src/Formatter.php';
    include_once __DIR__ . '/scssphp/src/Formatter/Compact.php';
    include_once __DIR__ . '/scssphp/src/Formatter/Compressed.php';
    include_once __DIR__ . '/scssphp/src/Formatter/Crunched.php';
    include_once __DIR__ . '/scssphp/src/Formatter/Debug.php';
    include_once __DIR__ . '/scssphp/src/Formatter/Expanded.php';
    include_once __DIR__ . '/scssphp/src/Formatter/Nested.php';
    include_once __DIR__ . '/scssphp/src/Formatter/OutputBlock.php';
    include_once __DIR__ . '/scssphp/src/Node.php';
    include_once __DIR__ . '/scssphp/src/Node/Number.php';
    include_once __DIR__ . '/scssphp/src/Parser.php';
    include_once __DIR__ . '/scssphp/src/SourceMap/Base64VLQEncoder.php';
    include_once __DIR__ . '/scssphp/src/SourceMap/SourceMapGenerator.php';
    include_once __DIR__ . '/scssphp/src/Type.php';
    include_once __DIR__ . '/scssphp/src/Util.php';
    include_once __DIR__ . '/scssphp/src/Version.php';
}
