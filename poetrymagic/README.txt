magicGallery: a set of PHP scripts for generating galleries from folders of images.
by: Edwin Fallwell (housewithinahouse.com)
- - - - - - -
1)Configuration:
	a)magic.php
		 This is were all of the constant variables live. Most of these change for every different website.
		 It also acts as the collector for all the different elements that go into making magic run. 
		 Include it anywhere you want to use magic. 
	b)js & css
		 These should live in their own folder. ie: /js/ and /css/.
2)Building pages:
	a)BasicWebElement
		Every element has the protected property $disp_string, inheirited from BasicWebElement, the superclass.
	  Every element also has a few built-in methods, as defined in BasicWebElement.
	  -prepend($string): adds strings passed to it to it at the start of the $disp_string.
	  -append($string): adds strings passed onto the end of the $disp_string
	  -beforeDisplay(): does in wrap-up tasks to the $disp_string, does nothing by default
	  -display(): calls beforeDisplay() and echos $disp_string
	b)Head
		Head doesn't take any arguments,
		 by default it will have a title in the format: $the_websiteName | $the_pageName
		-add css, by calling addStyleSheet($name), the path is "the_pathToCSS.$name"
		-add less, by calling addLess($name), the path is "the_pathToCSS.$name"
		-add scripts, by calling addScript($name), the path is "$the_pathToJS.$name"
		-finally, call display() to add it's HTML to the page.
			<?
			//EXAMPLE:
				$b = new Head();
				$b->addStyleSheet("default.css");
				$b->display();
			?>
	c)Menu
		Menu takes one argument: $class. It goes through each link array in $the_linkList,
		adds tags, and fills in the blanks. Display is done in the usual way.
			<?
			//EXAMPLE:
				$c = new Menu("leftSide");
				$c->display();
			?>
	d)BasicMagicElement
		These are the basic building blocks. When creating a new BasicMagicElement,
		You supply it with array keyed with the property names you want to set.
		All property names are in the format: "tagName_tagProperty", ex: "a_href". 
		These names are stored in $specs, BasicMagicElement's only new property. 			
			<?
			//EXAMPLE:
				$d1_specs = array(
					"img_src" => "/images/default.jpg",
					"a_href" => "/images/",
					"a_class" => "default"
					);
				$d1 = new BasicMagicElement($test_specs);
			?>
		There are also some methods avaible to this class:
			-set($specs):
				for each $spec in $specs, intergrate into $this->specs.
			-add($tag_type, $specs):
				calls set($specs),
				then append(openingTag($this->specs), innerHTML($this->specs), closingTag($this->specs)).
			-wrap($tag_type, $specs):
				calls set($specs),
				then prepend(openingTag($this->specs)),
				then append(innerHTML($this->specs), closingTag($this->specs)).
			<?
			//EXAMPLE:
				$d1->add("img");
				$d1->wrap("a", array("a_class" => "changed"));
				$d1->add("figcaption", "figcaption_inner"=>"this is the caption");
				$d1->display();
			?>
		The intent of the BasicMagicFigure is as a parent class to be extended to whatever
		specialized figures that might be needed. Formating work can be done
		by overriding beforeDisplay() and the __constructor.
	e)BasicMagicGroup
		BasicMagicGroup is a class for creating and handling a group of BasicMagicElements,
		or a group of child classes of BasicMagicElements. It is an extension of BasicMagicElement, 
		which in turn is an extension of BasicWebElement, so it has both of their properties: 
		$disp_string & $specs. $specs is used for holding defaults for new 
		It adds one new property: $elementGroup. It is an array that hold all of the objects 
		that it is responcable for. 
			<?
			//EXAMPLE:
				$e1 = new BasicMagicGroup($e1_specs);
			?>		
		It is an extension of BasicMagicElement, and as such, has all of the methods as it's parent.
		In addition, it has the following methods avaible:
			-make($obj_type, $specs):
				creates a new $obj_type($specs) and adds it to the end of $elementGroup. 
			-setEach($specs):
				calls set($specs) on each object in $elementGroup.
			-addEach($make_type, $specs)
				calls add($make_type, $specs) on each object in $elementGroup.
			-wrapsEach($make_type, $specs)
				calls wrap($make_type, $specs) on each object in $elementGroup.				
			-beforeDisplay() is used to add each object's $disp_string in $elementGroup to BasicMagicElement's $disp_string. 
	
		There are some specialized versions of make, for creating many objects at the same time from 
		different types of parameters.
			-makeFromArray($obj_type, $array_of_specs):
				foreach $array_of_specs as $specs{ make($specs) }
			-makeFromImages($obj_type, $array_of_specs):


--v.01
ROADMAP:
	add ability to specify base path for css & js / whatever. Should be a constant? set in vars.php
	in folders like liv's comics or other, pages should be created for sequencial sets of images automajicaly,
		the pages should  delineate by x_thumb.jpg, x1.jpg, x2.jpg, x...
	make a class for adding in text; retrived from files in the directory ./words?
		the ability to draw <figcaption>'s from .txt file?
	auto thumb generation! using imagemagick! It looks so easy!
	think about usin glob?
