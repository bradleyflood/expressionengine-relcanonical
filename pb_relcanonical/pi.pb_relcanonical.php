<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name'        => 'Simple rel=canonical',
  'pi_version'     => '1.0.0',
  'pi_author'      => 'Bradley Flood',
  'pi_author_url'  => 'http://www.punchbuggy.com.au/',
  'pi_description' => 'Simple rel=canonical meta tag plugin',
  'pi_usage'       => Pb_relcanonical::usage()
  );


class Pb_relcanonical
{

  public function Pb_relcanonical()
  {
    $this->EE =& get_instance();
  }
  
  /**
   * Output the rel canonical tag
   * {exp:pb_relcanonical:linkmeta strip_last_slash="yes"}
   * @access  public
   * @return  string
   */
  public function linkmeta()
  {
    // Strip last slash?
    $stripSlash = ee()->TMPL->fetch_param('strip_last_slash') == "yes" ? true : false;
    
    // Grab the URI
    $uri = $_SERVER["REQUEST_URI"];
    
    // Remove the query string
    $uriPop = explode('?', $uri);
    $uri = $uriPop[0];

    // Strip the slashes
    $uri = rtrim($uri, "/");
    $uri = ltrim($uri, "/");
    
    // Grab the segments 
    $segments = explode('/', $uri);
    $segmentCount = count($segments);
    
    // Check if last segment is pagination
    $lastSegment = $segments[$segmentCount-1];
    if( preg_match('/P(\d+)/', $lastSegment) )
    {
      // Last segment is pagination, pop it off the segments array
      array_pop($segments);
    }
    
    // Before building link tag, check if http or https
    $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';

    // Build url
    $linkUrl  = $protocol;
    $linkUrl .= '://' . $_SERVER['HTTP_HOST'] . '/';
    foreach ($segments as $segment)
    {
      $linkUrl .= $segment . '/';
    }
    
    // Strip slash?
    if( $stripSlash )
    {
      $linkUrl = rtrim($linkUrl, "/"); // Trim last '/'
    }
    
    // Build link tag
    $linkTag = '<link rel="canonical" href="'.$linkUrl .'" />';
    
    return $linkTag;
  }


	/**
	 * Usage
	 * This function describes how the plugin is used.
	 * @access	public
	 * @return	string
	 */
	
  public function usage()
  {
	  ob_start(); 
	  ?>
    
Simply add {exp:pb_relcanonical:linkmeta strip_last_slash="yes"} in your header
Will output <link rel='canonical' href='{the_rel_canonical_url}' />
Set 'stip_last_slash' parameter to "yes" or "no".

	  <?php
	  $buffer = ob_get_contents();
		
	  ob_end_clean(); 

	  return $buffer;
  }

}
