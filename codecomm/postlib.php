<?php
function htmlwrap($str, $width = 60, $break = "\n", $nobreak = "") { 

  // Split HTML content into an array delimited by < and > 
  // The flags save the delimeters and remove empty variables 
  $content = preg_split("/([<>])/", $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY); 

  // Transform protected element lists into arrays 
  $nobreak = explode(" ", strtolower($nobreak)); 

  // Variable setup 
  $intag = false; 
  $innbk = array(); 
  $drain = ""; 

  // List of characters it is "safe" to insert line-breaks at 
  // It is not necessary to add < and > as they are automatically implied 
  $lbrks = "/?!%)-}]\\\"':;&"; 

  // Is $str a UTF8 string? 
  $utf8 = (preg_match("/^([\x09\x0A\x0D\x20-\x7E]|[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]|\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})*$/", $str)) ? "u" : ""; 

  while (list(, $value) = each($content)) { 
    switch ($value) { 

      // If a < is encountered, set the "in-tag" flag 
      case "<": $intag = true; break; 

      // If a > is encountered, remove the flag 
      case ">": $intag = false; break; 

      default: 

        // If we are currently within a tag... 
        if ($intag) { 

          // Create a lowercase copy of this tag's contents 
          $lvalue = strtolower($value); 

          // If the first character is not a / then this is an opening tag 
          if ($lvalue{0} != "/") { 

            // Collect the tag name    
            preg_match("/^(\w*?)(\s|$)/", $lvalue, $t); 

            // If this is a protected element, activate the associated protection flag 
            if (in_array($t[1], $nobreak)) array_unshift($innbk, $t[1]); 

          // Otherwise this is a closing tag 
          } else { 

            // If this is a closing tag for a protected element, unset the flag 
            if (in_array(substr($lvalue, 1), $nobreak)) { 
              reset($innbk); 
              while (list($key, $tag) = each($innbk)) { 
                if (substr($lvalue, 1) == $tag) { 
                  unset($innbk[$key]); 
                  break; 
                } 
              } 
              $innbk = array_values($innbk); 
            } 
          } 

        // Else if we're outside any tags... 
        } else if ($value) { 

          // If unprotected... 
          if (!count($innbk)) { 

            // Use the ACK (006) ASCII symbol to replace all HTML entities temporarily 
            $value = str_replace("\x06", "", $value); 
            preg_match_all("/&([a-z\d]{2,7}|#\d{2,5});/i", $value, $ents); 
            $value = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x06", $value); 

            // Enter the line-break loop 
            do { 
              $store = $value; 

              // Find the first stretch of characters over the $width limit 
              if (preg_match("/^(.*?\s)?([^\s]{".$width."})(?!(".preg_quote($break, "/")."|\s))(.*)$/s{$utf8}", $value, $match)) { 

                if (strlen($match[2])) { 
                  // Determine the last "safe line-break" character within this match 
                  for ($x = 0, $ledge = 0; $x < strlen($lbrks); $x++) $ledge = max($ledge, strrpos($match[2], $lbrks{$x}));
                  if (!$ledge) $ledge = strlen($match[2]) - 1; 

                  // Insert the modified string 
                  $value = $match[1].substr($match[2], 0, $ledge + 1).$break.substr($match[2], $ledge + 1).$match[4]; 
                } 
              } 

            // Loop while overlimit strings are still being found 
            } while ($store != $value); 

            // Put captured HTML entities back into the string 
            foreach ($ents[0] as $ent) $value = preg_replace("/\x06/", $ent, $value, 1); 
          } 
        } 
    } 

    // Send the modified segment down the drain 
    $drain .= $value; 
  } 

  // Return contents of the drain 
  return $drain; 
} 

	function replacebb($noinexistent, $nobb, $tabs, $msg) {
		//$msg = stripslashes($msg);
		$htmltags = array (
			"#<br>#u",
			"#\n#u",
			"#<hr>#u",
			"#<img ([\w\W]*?)>#");
		$xhtmltags = array (
			"<br/>",
			"<wbr/>",
			"<hr/>",
			"<img $1 />");
		if ($nobb) {
			$directrep = array (
				"#\n#u",
				"#[\s][\s]#u",
				"#<br>#u");
			$directrep_html = array (
				"<br>",
				" &nbsp;",
				"<br>");
		}
		else {
			$directrep = array (
				"#\n#",
				"#\[b\]([\w\W]*?)\[/b\]#iu",
				"#\[i\]([\w\W]*?)\[/i\]#iu",
				"#\[u\]([\w\W]*?)\[/u\]#iu",
				"#\[s\]([\w\W]*?)\[/s\]#iu",
				"#\[strike\]([\w\W]*?)\[/strike\]#iu",
				"#\[hr\]#iu",
				"#\[header\]([\w\W]*?)\[/header\]#iu",
				"#\[align[\s]*=[\s]*(left|right|center)\]([\w\W]*?)\[/align\]#iu",
				"#\[align[\s]*=[\s]*&quot;(left|right|center)&quot;\]([\w\W]*?)\[/align\]#iu",
				"#\[align[\s]*=[\s]*'(left|right|center)'\]([\w\W]*?)\[/align\]#iu",
				"#\[size[\s]*=[\s]*[0]*([1-2]?[0-9]?[0-9])\]([\w\W]*?)\[/size\]#iu",
				"#\[size[\s]*=[\s]*&quot;[0]*([1-2]?[0-9]?[0-9])&quot;\]([\w\W]*?)\[/size\]#iu",
				"#\[size[\s]*=[\s]*'[0]*([1-2]?[0-9]?[0-9])'\]([\w\W]*?)\[/size\]#iu",
				"#\[spoiler\]([\w\W]*?)\[/spoiler\]#iu",
				"#\[code\]([\w\W]*?)\[/code\]#iu",
				"#\[url\][\s]*(?!j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t)([A-Za-z0-9_.~\\-!*'();:@&=+$,/?%\\#\\[\\]]*?)[\s]*\[/url\]#iu",
				"#\[url[\s]*=[\s]*&quot;[\s]*(?!j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t)([A-Za-z0-9_.~\\-!*'();:@&=+$,/?%\#\\[\\]]+?)&quot;\]([\w\W]*?)\[/url\]#iu",
				"#\[url[\s]*=[\s]*'[\s]*(?!j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t)([A-Za-z0-9_.~\\-!*'();:@&=+$,/?%\#\\[\\]]+?)'\]([\w\W]*?)\[/url\]#iu",
				"#\[url[\s]*=[\s]*(?!j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t)([A-Za-z0-9_.~\\-!*'();:@&=+$,/?%\#\\[\\]]+?)\]([\w\W]*?)\[/url\]#iu",
				"#\[img[\s]*=[\s]*&quot;[\s]*(?!j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t)([A-Za-z0-9_.~\\-!*'();:@&=+$,/?%\#\\[\\]]*?)&quot;\]#iu",
				"#\[img[\s]*=[\s]*'[\s]*(?!j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t)([A-Za-z0-9_.~\\-!*'();:@&=+$,/?%\#\\[\\]]*?)'\]#iu",
				"#\[img[\s]*=[\s]*(?!j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t)([A-Za-z0-9_.~\\-!*'();:@&=+$,/?%\#\\[\\]]*?)\]#iu",
				"#\[img][\s]*(?!j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t)([A-Za-z0-9_.~\\-!*'();:@&=+$,/?%\#\\[\\]]*?)\[/img\]#iu",
				"#\[color[\s]*=[\s]*\#([0-9A-Fa-f]{3})\]([\w\W]*?)\[/color\]#iu",
				"#\[color[\s]*=[\s]*&quot;\#([0-9A-Fa-f]{3})&quot;\]([\w\W]*?)\[/color\]#iu",
				"#\[color[\s]*=[\s]*'\#([0-9A-Fa-f]{3})'\]([\w\W]*?)\[/color\]#iu",
				"#\[color[\s]*=[\s]*\#([0-9A-Fa-f]{6})\]([\w\W]*?)\[/color\]#iu",
				"#\[color[\s]*=[\s]*&quot;\#([0-9A-Fa-f]{6})&quot;\]([\w\W]*?)\[/color\]#iu",
				"#\[color[\s]*=[\s]*'\#([0-9A-Fa-f]{6})'\]([\w\W]*?)\[/color\]#iu",
				"#\[color[\s]*=[\s]*(aqua|black|blue|fuchsia|gray|green|lime|maroon|navy|olive|purple|red|silver|teal|white|yellow)\]([\w\W]*?)\[/color\]#iu",
				"#\[color[\s]*=[\s]*&quot;(aqua|black|blue|fuchsia|gray|green|lime|maroon|navy|olive|purple|red|silver|teal|white|yellow)&quot;\]([\w\W]*?)\[/color\]#iu",
				"#\[color[\s]*=[\s]*'(aqua|black|blue|fuchsia|gray|green|lime|maroon|navy|olive|purple|red|silver|teal|white|yellow)'\]([\w\W]*?)\[/color\]#iu",
				"#\[youtube[\s]*=[\s]*&quot;([A-Za-z0-9_\-]{11})&quot;\]#iu",
				"#\[youtube[\s]*=[\s]*'([A-Za-z0-9_\-]{11})'\]#iu",
				"#\[youtube[\s]*=[\s]*([A-Za-z0-9_\-]{11})\]#iu",
				"#\[youtube[\s]*=[\s]*&quot;http://www.youtube.com/(watch(\?v=|[\w\W]*?&amp;v=)|v/)([A-Za-z0-9_\-]{11})[\w\W]*?&quot;\]#iu",
				"#\[youtube[\s]*=[\s]*'http://www.youtube.com/(watch(\?v=|[\w\W]*?&amp;v=)|v/)([A-Za-z0-9_\-]{11})[\w\W]*?'\]#iu",
				"#\[youtube[\s]*=[\s]*http://www.youtube.com/(watch(\?v=|[\w\W]*?&amp;v=)|v/)([A-Za-z0-9_\-]{11})[\w\W]*?\]#iu",
				"#\[youtube][\s]*([A-Za-z0-9_\-]{11})[\s]*\[/youtube\]#iu",
				"#\[list\]([\w\W]*?)\[/list\]#iu",
				"#\[list[\s]*=[\s]*([1AaIi])\]([\w\W]*?)\[/list\]#iu",
				"#\[list[\s]*=[\s]*&quot;([1AaIi])&quot;\]([\w\W]*?)\[/list\]#iu",
				"#\[list[\s]*=[\s]*'([1AaIi])'\]([\w\W]*?)\[/list\]#iu",
				"#\[\*\]([\w\W]*?)\[/\*\]#iu",
				"#[\s][\s]#u",
				"#<br>#iu");
			$directrep_html = array (
				"<br>",
				"<b>$1</b>",
				"<i>$1</i>",
				"<u>$1</u>",
				"<span style=\"text-decoration: line-through;\">$1</span>",
				"<span style=\"text-decoration: line-through;\">$1</span>",
				"<hr>",
				"<h3>$1</h3>",
				"<p align=\"$1\">$2</p>",
				"<p align=\"$1\">$2</p>",
				"<p align=\"$1\">$2</p>",
				"<span style=\"font-size: $1%\">$2</span>",
				"<span style=\"font-size: $1%\">$2</span>",
				"<span style=\"font-size: $1%\">$2</span>",
				"<span style=\"background-color: white;\">$1</span>",
				"<span style=\"font-family: Courier New;border-style: solid;border-width: 1px;background-color: #CCC;color: #000;display: block;\">$1</span>",
				"<a href=\"redirect.php?url=$1\" target=\"_blank\">$2</a>",
				"<a href=\"redirect.php?url=$1\" target=\"_blank\">$2</a>",
				"<a href=\"redirect.php?url=$1\" target=\"_blank\">$2</a>",
				"<a href=\"redirect.php?url=$1\" target=\"_blank\">$2</a>",
				"<img src=\"$1\" id=\"$1\" onload=\"resize_img(this.id);\" style=\"visibility:hidden;\"/>",
				"<img src=\"$1\" id=\"$1\" onload=\"resize_img(this.id);\" style=\"visibility:hidden;\"/>",
				"<img src=\"$1\" id=\"$1\" onload=\"resize_img(this.id);\" style=\"visibility:hidden;\"/>",
				"<img src=\"$1\" id=\"$1\" onload=\"resize_img(this.id);\" style=\"visibility:hidden;\"/>",
				"<span style=\"color:#$1;\">$2</span>",
				"<span style=\"color:#$1;\">$2</span>",
				"<span style=\"color:#$1;\">$2</span>",
				"<span style=\"color:#$1;\">$2</span>",
				"<span style=\"color:#$1;\">$2</span>",
				"<span style=\"color:#$1;\">$2</span>",
				"<span style=\"color:$1;\">$2</span>",
				"<span style=\"color:$1;\">$2</span>",
				"<span style=\"color:$1;\">$2</span>",
				"<br><object width=\"350\" height=\"220\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><param name=\"allowfullscreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"false\" width=\"350\" height=\"220\"></embed></object><br>",
				"<br><object width=\"350\" height=\"220\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><param name=\"allowfullscreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"false\" width=\"350\" height=\"220\"></embed></object><br>",
				"<br><object width=\"350\" height=\"220\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><param name=\"allowfullscreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"false\" width=\"350\" height=\"220\"></embed></object><br>",
				"<br><object width=\"350\" height=\"220\"><param name=\"movie\" value=\"http://www.youtube.com/v/$3\"></param><param name=\"allowfullscreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$3\" type=\"application/x-shockwave-flash\" allowfullscreen=\"false\" width=\"350\" height=\"220\"></embed></object><br>",
				"<br><object width=\"350\" height=\"220\"><param name=\"movie\" value=\"http://www.youtube.com/v/$3\"></param><param name=\"allowfullscreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$3\" type=\"application/x-shockwave-flash\" allowfullscreen=\"false\" width=\"350\" height=\"220\"></embed></object><br>",
				"<br><object width=\"350\" height=\"220\"><param name=\"movie\" value=\"http://www.youtube.com/v/$3\"></param><param name=\"allowfullscreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$3\" type=\"application/x-shockwave-flash\" allowfullscreen=\"false\" width=\"350\" height=\"220\"></embed></object><br>",
				"<br><object width=\"350\" height=\"220\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><param name=\"allowfullscreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"false\" width=\"350\" height=\"220\"></embed></object><br>",
				"<ul>$1</ul>",
				"<ol type=\"$1\"\">$2</ol>",
				"<ol type=\"$1\"\">$2</ol>",
				"<ol type=\"$1\"\">$2</ol>",
				"<li>$1</li>",
				" &nbsp;",
				"<br>");
		}
		$escaperep = array ("\\[", "\\]");
		$escaperep_final = array ("[", "]");
		$msg = htmlspecialchars($msg, ENT_COMPAT, 'UTF-8');
		$msg = preg_replace($directrep, $directrep_html, $msg);
		if ($noinexistent) {
			$msg = str_replace(array("á", "é"), array("&aacute;", "&eacute;"), $msg);
			$msg = str_replace($escaperep, array ("á", "é"), $msg);
			$msg = preg_replace("#\\[[\\w\\W]*?\\]#u", "", $msg);
			$msg = str_replace(array ("á", "é"), $escaperep, $msg);
			$msg = str_replace(array("&aacute;", "&eacute;"), array("á", "é"), $msg);
		}
		if (!$nobb) {
			$msg = str_replace($escaperep, $escaperep_final, $msg);
		}
		$msg = htmlwrap($msg, 72, "\n");
		$msg = preg_replace($htmltags, $xhtmltags, $msg);
		return $msg."<wbr>";
	}
?>
