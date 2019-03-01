# Brill Tagger 
[![Build Status](https://travis-ci.org/ekinhbayar/BrillTagger.svg?branch=master)](https://travis-ci.org/ekinhbayar/BrillTagger) [![Code Coverage](https://scrutinizer-ci.com/g/ekinhbayar/BrillTagger/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ekinhbayar/BrillTagger/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ekinhbayar/BrillTagger/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ekinhbayar/BrillTagger/?branch=master)

PHP implementation of a Brill Tagger, an inductive part-of-speech tagging method.
Uses a lexicon generated from [Brown Corpus](https://github.com/ekinhbayar/brown-corpus).

### Installation

`$ composer require ekinhbayar/brill-tagger` then run `$ composer install`. The latter will define the lexicon.

or just clone/download this repository.

### Usage

```php
$input = "The quick brown fox jumps over the lazy dog.";
$tagger = new BrillTagger();
$tagger->tag($input);
```
