[center][hr][color=red][size=16pt][b]YOUTUBE BBCODE v2.4[/b][/size][/color]
[url=http://custom.simplemachines.org/mods/index.php?action=profile;u=23577][b]Update by Runic[/b][/url]
[url=http://custom.simplemachines.org/mods/index.php?action=profile;u=63186][b]Vreated By Karl Benson[/b][/url]
[hr][url=http://custom.simplemachines.org/mods/index.php?mod=936][b]Link to Mod[/b][/url] | [url=http://www.simplemachines.org/community/index.php?topic=197280.0][b]Support Topic[/b][/url] | [url=http://www.adrevenueshare.com/index.php?topic=18.0][b]Demo[/b][/url] | [url=http://www.adrevenueshare.com/donate][b]Donate[/b][/url][hr][/center]

[color=blue][b][size=12pt][u]Compatibility[/u][/size][/b][/color]
For SMF 1.1.x and SMF 2.x

[color=blue][b][size=12pt][u]Introduction[/u][/size][/b][/color]
Embed Youtube videos into posts with the use of [nobbc][youtube][/youtube][/nobbc] bbcode.

Its the ultimate friendly youtube mod, supporting various link formats (including Playlist links), safely and securely parsing the information for the piece of mind of forum admins.

(Mysql only) If you have had my [ytplaylist] mod previously installed, then you might want to use my [url=http://custom.simplemachines.org/mods/index.php?mod=936]conversion script[/url] to convert [nobbc][ytplaylist] to [youtube][/nobbc] bbcode.
Upload it via ftp to your directory where SMF runs from. Put your forum in maintenance mode, and then point to it in your browser.

[color=blue][b][size=12pt][u]Features[/u][/size][/b][/color]
o Adds a BBCode Button to Insert [nobbc][youtube][/youtube][/nobbc] bbcode.
o Supports standard YouTube videos and YouTube playlists
- Standard: eg [nobbc]http://www.youtube.com/watch?v=FJ2UzCZiKgT[/nobbc]
- Playlist: eg [nobbc]http://www.youtube.com/view_play_list?p=595A40209CB17411[/nobbc]
o Supports links from all of YouTube global and localised sites
 > Global (with or without www.) | Brasil | France | India | Ireland | Israel | Italia | Japan | Nederland | Polska | Espana | United Kingdom
 > Australia | Hong Kong | Mexico | New Zealand | Deutsche | Canada | Russia | Taiwan | South Korea
o Supports various formats
- YouTube Page url
- Direct Embed url
- ID only
o Specify sizes (Optional)
- eg [nobbc][youtube=425,350][/youtube][/nobbc]
- Defaulting to default YouTube sizes if not specified
- Size Protection to prevent embedding videos larger than 780px or less than 100px
o Safe from a security standpoint
- Properly validates/sanitizes/parses the video id before including it in the url
- Disables script access (allowScriptAccess="never")
o Alternative link and/or text provided for
- Invalid video id/links
- Printer friendly versions
- Disabled bbcoded
- Disabled flash
o Supports Languages
- English/English-utf8
- English_British/English_British-utf8
- Brazilian/Brazilian-utf8 (Thanks to Softcore)
- German/German-utf8
- Italian/Italian-utf8 (Thanks to Edi67)
- Polish/Polish-utf8 (Thanks to Nolt)
- Portuguese/Portuguese-utf8 (Thanks to Softcore)
- Spanish/Spanish-utf8 (Thanks to EgAr)
- Spanish_es/Spanish_es-utf8 (Thanks to EgAr)
- Swedish/Swedish-utf8 (Thanks to Hobox)
- Turkish/Turkish-utf8 (Thanks to Cakal93)
I welcome translations for other languages. Please post the translated language strings in the Support Topic.

[color=blue][b][size=12pt][u]Installation[/u][/size][/b][/color]

Any previous versions of this mod need to be uninstalled prior to installing this version.

Installation slightly varies depending on SMF version.

[b]SMF 1.1.1 to 1.1.4 & SMF 2.0 Beta 1[/b]
Installing the mod will only fully install the mod on the SMF Default Core Theme.
For all other themes which have a custom Post.template.php a manual edit will be required to add the BBCode Button.
(SMF 2.0 Beta 1 Only) You can choose to have the SMF Package Manager attempt* to perform the manual edit on all themes.

FIND
[code]			'flash' => array('code' => 'flash',[/code]
ADD BEFORE
[code]			'youtube' => array('code' => 'youtube', 'before' => '[youtube]', 'after' => '[/youtube]', 'description' => $txt['youtube']),[/code]

You will also need to place a copy of the youtube.gif in each of your themes bbc image folders (eg Themes/{themename}/images/bbc)

If your using a language different than the ones supported this mod (listed above), then you will need to add the following to the Modifications.{language}.php for each theme (The language folder can be found eg Themes/{themename}/languages/)

FIND
[code]?>[/code]
ADD BEFORE (and translate as necessary the language strings)
[code]$txt['youtube'] = 'YouTube';
$txt['youtube_invalid'] = '#Invalid YouTube Link#';[/code]

[b]SMF 2.0 Beta 2 / Beta 3 / Beta 3 Public / RC 1[/b]
Since SMF 2.0 Beta 2, the BBCode buttons have been moved from the templates and into the source files.
Therefore no manual edits will normally be required. Installing the mod will automatically install it on ALL themes.

However you will still need to place a copy of the youtube.gif in each of your themes bbc image folders (eg Themes/{themename}/images/bbc)

And if your using a language different than the ones supported this mod (listed above), then you will need to add the following to the Modifications.{language}.php for each theme (The language folder can be found eg Themes/{themename}/languages/)

FIND
[code]?>[/code]
ADD BEFORE (and translate as necessary the language strings)
[code]$txt['youtube'] = 'YouTube';
$txt['youtube_invalid'] = '#Invalid YouTube Link#';[/code]

[b]Useful Links[/b]
[url=http://www.adrevenueshare.com/parser]SMF Package Parser[/url]
[url=http://docs.simplemachines.org/index.php?topic=402]Manual Installation Of Mods[/url]
[url=http://www.simplemachines.org/community/index.php?topic=24110.0]How Do I Modify Files?[/url]

[color=blue][b][size=12pt][u]Support[/u][/size][/b][/color]
Please use the modification thread for support with this modification.
(Please don't ask me to do the edits for you)

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
[b]2.5 - 24th April 2009[/b]
o Updated Description and owner
o Added Dutch Language (translated by Tom Te Selle)
[b]2.1 - 31st January 2008[/b]
o Support for YouTube Playlist links
o Optimized preg and rewrote regex
o Changed max size supported to 780px
o Now builds the object based on browser
[b]2.2 - 21st February 2008[/b]
o Added &rel=1 to all embed links as YouTube seesm to require it now.
[b]2.3 - 18th March 2008[/b]
o Ensured compatible with SMF 2.0 Beta 3 Public
o Added Polish language strings (Thanks to Nolt)
[b]2.4 - 5th October 2008[/b]
o Ensured compatible with SMF 2.0 Beta 4 and SMF 1.1.6
o Added YouTube FullScreen parameter (so player shows full screen button)
o Fixed encoded ampersands as &amp;
o Added Support for YouTube India (in), South Korea (kr) and Israel (il)
o Moved all language strings into a single file [languagestrings.xml] (save repetition) in the package