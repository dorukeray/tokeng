<?php
  namespace Tokeng;
  
  class Seeder
  {
    public const TOKEN_PATTERN = "/{{ ([a-zA-Z0-9$-_.]+) }}/";

    /**
     * Seeds data to a text
     *
     * @param string $template A text to seed
     * @param array $data A data array with key-value pairs
     *
     * @return string seeded HTML template
     */
    public static function seed(string $template, array $data)
    {
      $combinedTokens = self::parseTokensWithKeys($template, self::TOKEN_PATTERN);
      $contents = self::replacePlaceholders($template, $combinedTokens, $data);

      return $contents;
    }

    /**
     * Replaces placeholders with seed data
     *
     * @param string $template
     * @param string[] $tokens
     * @param string[] $seedData
     *
     * @return string The string whose tokens are replaced with seed data
     */
    public static function replacePlaceholders(string $contents, array $tokens, array $seedData)
    {
      # iterates through tokens list
      foreach ($tokens as $key => $token) {
        # sets a token value
        $tokenValue = ( isset($seedData[$key])
                      && is_string($seedData[$key]) )
                      ? $seedData[$key]
                      : false;

        if ($tokenValue !== false) {
          # replace each token by key-value pairs
          $contents = self::replaceToken($token, $tokenValue, $contents);
        } else { continue; }
      }
      # returns seeded contents
      return $contents;
    }

    /**
     * Replaces a token by its key and its value
     *
     * @return string
     */
    public static function replaceToken(string $tokenKey, string $value, string $contents)
    {
      return str_replace($tokenKey, $value, $contents);
    }

    /**
     * Parses a text and returns data for parsing
     *
     * @return array parse results
     * @return false on failure
     */
    public static function parseHTMLTemplate(string $template)
    {
      if($template !== "") {
        preg_match_all(self::TOKEN_PATTERN, $template, $results);
        return $results;
      } else return false;
    }

    /**
     * Parses tokens with keys, use this to seed template
     *
     * @param string $template
     * @param string $tokenPattern ~ RegEx pattern for tokens
     *
     * @return array
     */
    public static function parseTokensWithKeys(string $template, string $tokenPattern)
    {
      $parsed = self::parseHTMLTemplate($template, $tokenPattern);
      $keys = self::getKeysFromParseResults($parsed);
      $tokens = self::getTokensFromParseResults($parsed);

      $keyWithTokenList = array_combine($keys, $tokens);

      return $keyWithTokenList;
    }

    /**
     * Returns placeholder key list from parse results
     *
     * @param array $parseResults
     * @return array
     */
    public static function getKeysFromParseResults(array $parseResults)
    {
      return array_map(
        function($item) { return trim($item); }
        ,$parseResults[1]
      );
    }

    /**
     * Gets replacable tokens from parse results of HTML template
     *
     * @param array $parseResults
     * @return array token list
     */
    public static function getTokensFromParseResults(array $parseResults)
    {
      return $parseResults[0];
    }
  }
  