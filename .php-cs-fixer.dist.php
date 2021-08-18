<?php




use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->notPath('bootstrap/*')
    ->notPath('storage/*')
    ->notPath('resources/view/mail/*')
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

	$config = new Config();
	return $config->setRules([
		'@PSR2' => true,
		'array_syntax' => ['syntax' => 'short'],
		'ordered_imports' => ['sort_algorithm' => 'alpha'],
		'no_unused_imports' => true,
	])
	->setUsingCache(false)
	->setFinder($finder);
