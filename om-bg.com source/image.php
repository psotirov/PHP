<?php 
// Temporary active image
header('Content-type:image/png'); 
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', false);

// Extracts number for coding 
$salt = 'This+string+is+intended+to+carry+number+information';
$media = md5($salt.ceil(time()/200));
// $media is valid for at least 99 seconds
$codemedia = isset($_GET['rid']) ? $_GET['rid'] : "0";
if (strlen($media) != strlen($codemedia)) $number = 0; // different strings
else {
	$number = '';
	for($i=0;$i<strlen($media);$i++)
		if ($codemedia[$i] != $media[$i]) //at this position is code digit
		{
			// 1 digit hex difference of original media digit and code digit
			$val = hexdec($codemedia[$i])-hexdec($media[$i])-1;
			// -1 adjusts result because 1 was added when media was coded
			if ($val <0) $val += 16; //adjusts carry flag
			$number = $number.$val;
		}
	$number = intval($number);
}
if (($number < 10000) || ($number > 99999)) $error_msg = 'ERROR'; 

// Variables
////////////////////////////////////////////////////////////////////////// 
$x = 160; // Image width 
$y = 50; // Image height 
$freq=1000; // Frequency of the noise 
$noise_method="dots"; // line | dots | rectangle 
$font_selection = "random"; // random | fixed 
$font_folder = "images/"; // Fonts path 
$fonts = array("HoboStd.ttf", "mvboli.ttf", "StencilStd.ttf", 
"tt0142m.ttf", "PoplarStd.ttf", "OCR-a.ttf"); 
$default_font = 5; // default font index in array $fonts. 
$angle_selection = "random"; // random | fixed 
$max_angle = 10; // Max rotation angle of the number
$default_angle = 0; // Default rotation angle 
$font_size = 30; // Size of the nuber
////////////////////////////////////////////////////////////////////////// 

// Selects font
if ($font_selection=="random")
{ 
	$font = rand(0, count($fonts)-1); 
	$font = $font_folder.$fonts[$font]; 
} else $font = $font_folder.$fonts[$default_font]; 

// Selects rotation angle 
if ($angle_selection=="random") $angle = rand((-1)*($max_angle/2), ($max_angle/2)); 
	else $angle = $default_angle; 

// Creates background image 
$img = @ImageCreate($x, $y) or die("Couldn't create image"); 

// Colors selection
$black = ImageColorAllocate($img, 0, 0, 0); 
$white = ImageColorAllocate($img, 255, 255, 255);
 

function get_random_colors() /* Function for creating of the contrast random colors.*/ 
{ 
	// $bck = array of colors (R,G,B) for background
	// $dot = array of colors (R,G,B) for noise
	// $txt = array of colors (R,G,B) for number 
	
	$bck=array(); $dot=array(); $txt=array(); 
	// i=O =>Red | i=1 =>Green | i=2 =>Blue
	for ($i=0; $i<3; $i++)
	{ 
		$x = rand(0,132); 
		$y = rand(191,255); 
		array_push($bck, $x); 
		array_push($dot, (255-$x)); 
		array_push($txt, $y); 
	} 
	// Returns array of 3 arrays: [0..2, 0..2] 
	return array($bck, $dot, $txt); 
} 

$rnd_col = get_random_colors(); 
$background = ImageColorAllocate($img, $rnd_col[0][0], $rnd_col[0][1], $rnd_col[0][2]); 
$dots_color = ImageColorAllocate($img, $rnd_col[1][0], $rnd_col[1][1], $rnd_col[1][2]); 
$text_color = ImageColorAllocate($img, $rnd_col[2][0], $rnd_col[2][1], $rnd_col[2][2]); 

// if sent number is incorrect 
if (isset($error_msg))
{ 
	// White background
	ImageFill($img, 100, 50, $white); 
	// Shows error message
	ImageString($img, 2, 20, 10, $error_msg, $black); 
} else { 
	// Fill background with its color 
	ImageFill($img, 100, 50, $background); 
	// Centering number in the image 
	$arr=ImageTtfbBox($font_size, $angle, $font, $number);
	$text_x= round(($x-(abs($arr[2]-$arr[0]))) / 2, 0); 
	$text_y= round(($y-(abs($arr[5]-$arr[3]))) / 2, 0); 
	ImageTTFText($img, $font_size, $angle, $text_x, $text_y - $arr[5], $text_color, $font, $number); 
	
	$i=0; //<---------Noise counter 
	
	// Puts noise in the image
	while ($i < $freq)
	{ 
		$dotX = rand(0, $x); $dotY = rand(0, $y); 
		switch ($noise_method)
		{ 
			case "line": 
				$line_width = rand(4,20); 
				if (rand(0,10)>=5)
					// Horizontal line 
					ImageLine($img, $dotX, $dotY, $dotX+$line_width, $dotY, $dots_color); 
				else 
					// Vertical line
					ImageLine($img, $dotX, $dotY, $dotX, $dotY+$line_width, $dots_color); 
				break; 
			case "dots": 
				ImageSetPixel($img, $dotX, $dotY, $dots_color); 
				break; 
			case "rectangle": 
				ImageRectangle($img, $dotX-1, $dotY-1, $dotX+1, $dotY+1, $dots_color); 
				break; 
		} 
		$i++; 
	} 
} 

//Sending image and freeing memory
ImagePNG($img);
ImageDestroy($img); 
?> 

