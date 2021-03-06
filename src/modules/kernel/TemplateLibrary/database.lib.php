<?php
/**
 * Cetemaster Services
 * Cetemaster Framework v1.0
 *
 * Template Engine: PHP Database
 * Author: $CTM['Erick-Master']
 * Last Update: 31/08/2012 - 04:28h
 *
 * Cetemaster Services, Limited
 * Copyright (c) 2010-2013. All Rights Reserved, 
 * www.cetemaster.com.br / www.cetemaster.com
*/

class TemplateEngine_Database extends CTM_Template
{
	private $settings	= array();
	private $database	= array();
	private $tpl_folder	= NULL;
	private $file_name	= NULL;
	private $opened		= FALSE;
	private $update		= FALSE;
	
	/**
	 *	Library Factory
	 *	Set up a library setting
	 *
	 *	@param	array	Library Settings
	 *	@return	void
	*/
	public function LibFactory($settings)
	{
		$this->settings = $settings;
	}
	/**
	 *	Open Database
	 *	Open or create the database
	 *
	 *	@param	string	Template name
	 *	@param	string	Category name
	 *	@return	boolean
	*/
	public function OpenDatabase($template, $category)
	{
		if($this->opened == false)
		{
			$this->database = array();
			$this->tpl_folder = $template;
			$this->file_name = $category;
			
			if(file_exists($this->settings['DatabaseDir'].$template."/skin_".$category.".tpl.php"))
			{
				require_once($this->settings['DatabaseDir'].$template."/skin_".$category.".tpl.php");
				$this->database = $CTM_TEMPLATE_DATABASE;
				
				unset($CTM_TEMPLATE_DATABASE);
			}
			
			return $this->opened = true;
		}
	}
	/**
	 *	Check template file
	 *	Check if the template file exists
	 *
	 *	@param	string	File name
	 *	@return	boolean
	*/
	public function CheckFile($name)
	{
		if($this->opened == true)
			return $this->database[$name] == true;
	}
	/**
	 *	Get template file
	 *	Get the template file
	 *
	 *	@param	string			File name
	 *	@param	&string|bool	Template content
	 *	@return	string|bool
	*/
	public function GetFile($name, &$return = NULL)
	{
		if($this->opened == true)
			return $return = $this->database[$name] ? str_replace(array("::x####$####x::", "::x####code:n####x::"), array("$", "\\n"), $this->database[$name]) : false;
			
		return -1;
	}
	/**
	 *	Add/Edit template file
	 *	Add/Edit file in category of template
	 *
	 *	@param	string	File name
	 *	@param	string	File content
	 *	@return	void
	*/
	public function SetFile($name, $content)
	{
		if($this->opened == true)
		{
			$this->database[$name] = str_replace(array("$", "\\n"), array("::x####$####x::", "::x####code:n####x::"), $content);
			$this->update = TRUE;
		}
	}
	/**
	 *	Get All Files
	 *	Get all template files
	 *
	 *	@param	&array	Template files
	 *	@return	array
	*/
	public function GetAllFiles(&$return = array())
	{
		if($this->opened == true)
			foreach($this->database as $key => $value)
				$return[$key] = str_replace(array("::x####$####x::", "::x####code:n####x::"), array("$", "\\n"), $value);
				
		return $return;
	}
	/**
	 *	Remove template file
	 *	Remove file in category of template
	 *
	 *	@param	string	File name
	 *	@return	void
	*/
	public function RemoveFile($name)
	{
		if($this->opened == true)
		{
			unset($this->database[$name]);
			$this->update = TRUE;
		}
	}
	/**
	 *	Compile Cache File
	 *	Compile the HTML Logic from files to cache
	 *
	 *	@return	void
	*/
	public function CompileCache()
	{
		$full_path = CTM_CACHE_PATH."skin_cache/templates/".$this->tpl_folder."/skin_".$this->file_name.".php";
		
		parent::Lib('Logic')->PrepareToBuild();
		
		foreach($this->database as $key => $value)
			parent::Lib('Logic')->ConvertHTMLToPHP(str_replace(array("::x####$####x::", "::x####code:n####x::"), array("$", "\\n"), $value), $key, NULL);
			
		parent::Lib('Logic')->CompileSkinFile("skin_".$this->file_name, "skin_".$this->file_name, $full_path);
	}
	/**
	 *	Close Database
	 *	Close and extract the database
	 *
	 *	@return	void
	*/
	public function CloseDatabase()
	{
		if($this->opened == true)
		{
			if($this->update == true)
			{
				$date = date("d/m/Y - H:i");
				$yy = date("Y");
				
				$skinFile = "<?php\n";
				$skinFile .= "/***********************************************************/\n";
				$skinFile .= "/* Cetemaster Services, Limited                            */\n";
				$skinFile .= "/* Copyright (c) 2010-$yy. All Rights Reserved,           */\n";
				$skinFile .= "/* www.cetemaster.com.br / www.cetemaster.com              */\n";
				$skinFile .= "/***********************************************************/\n";
				$skinFile .= "/* File generated by Cetemaster PHP Template Engine        */\n";
				$skinFile .= "/* Template: ".     str_pad($this->tpl_folder, 46, " ").          "*/\n";
				$skinFile .= "/* DB file: ".     str_pad("skin_".$this->file_name, 47, " ").          "*/\n";
				$skinFile .= "/* DB generated in ".  str_pad($date."h", 40, " ").       "*/\n";
				$skinFile .= "/***********************************************************/\n";
				$skinFile .= "/* This is a cache file generated by ".str_pad($this->settings['SystemName'], 22, " ")."*/\n";
				$skinFile .= "/* DO NOT EDIT DIRECTLY                                    */\n";
				$skinFile .= "/* The changes are not saved to the cache automatically    */\n";
				$skinFile .= "/***********************************************************/";
				
				foreach($this->database as $key => $value)
				{
					$skinFile .= "\n\n/********** Begin: {$key} **********/\n";
					$skinFile .= "\$CTM_TEMPLATE_DATABASE['".$key."'] = <<<HTML\n";
					$skinFile .= $value."\nHTML;";
					$skinFile .= "\n/********** End: {$key} **********/";
				}
					
				$fp = fopen($this->settings['DatabaseDir'].$this->tpl_folder."/skin_".$this->file_name.".tpl.php", "wb");
				fwrite($fp, $skinFile);
				fclose($fp);
			}
			
			$this->database = array();
			$this->tpl_folder = NULL;
			$this->file_name = NULL;
			$this->opened = FALSE;
			$this->update = FALSE;
		}
	}
}