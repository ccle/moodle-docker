<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

//////////

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
//$CFG->dbhost    = 'localhost';
$CFG->dbhost = '192.168.99.100';
$CFG->dbname    = '';
$CFG->dbuser    = '';
$CFG->dbpass    = '';
$CFG->prefix    = 'mdl_';
$CFG->dboptions['dbpersist'] = 0;
$CFG->dboptions['dbsocket']  = 1;
$CFG->dboptions['dbcollation'] = 'utf8mb4_unicode_ci';

$CFG->wwwroot  = '';
$CFG->dataroot = '';

// This determines what the admin folder is called.
$CFG->admin    = 'admin';

// This is directory permissions for newly created directories
$CFG->directorypermissions = 0777;

// This should never change after the first install, or else any special
// logins using the Moodle login will not work.
$CFG->passwordsaltmain = '';

// Determines current term
//$CFG->currentterm = '12S';

// Registrar
$CFG->registrar_dbtype = 'odbc_mssql';
$CFG->registrar_dbhost = '';
$CFG->registrar_dbuser = '';
$CFG->registrar_dbpass = '';
$CFG->registrar_dbname = 'srdb';
$CFG->registrar_dbencoding = 'ISO-8859-1';

// Format and browseby and anything else that requires instructors to be
// displayed, we need to determine which roles should be displayed.
$CFG->instructor_levels_roles['Instructor'] = array('editinginstructor', 'ta_instructor');
$CFG->instructor_levels_roles['Teaching Assistant'] = array('ta', 'ta_admin');
$CFG->instructor_levels_roles['Student Facilitator'] = array('studentfacilitator');

// To enable friendly urls in your dev instance, please add the config values to
// your config_private.php
//// CCLE-2283: Friendly URLs
//// CCLE-2283: Redirect to archive (these have a high chance of changing)
//$CFG->forced_plugin_settings['local_ucla']['friendly_urls_enabled] = false;
//$CFG->forced_plugin_settings['local_ucla']['remotetermcutoff] = '';
//$CFG->forced_plugin_settings['local_ucla']['archiveserver] = '';

// My Sites CCLE-2810
// Term limiting
$CFG->forced_plugin_settings['local_ucla']['student_access_ends_week'] = 3;
$CFG->forced_plugin_settings['local_ucla']['oldest_available_term'] = '08S';

// Browseby CCLE-2894
$CFG->forced_plugin_settings['block_ucla_browseby']['use_local_courses'] = true;
$CFG->forced_plugin_settings['block_ucla_browseby']['ignore_coursenum'] = '194,295,296,375';
$CFG->forced_plugin_settings['block_ucla_browseby']['allow_acttypes'] = 'CLI,LEC,SEM,LAB,FLD,ACT,STU,REC,RGP';

// Course builder \\
//$terms_to_built = array('12S', '121', '12F');

// Course Requestor
//$CFG->forced_plugin_settings['tool_uclacourserequestor']['terms'] = $terms_to_built;
$CFG->forced_plugin_settings['tool_uclacourserequestor']['mailinst_default'] = false;
$CFG->forced_plugin_settings['tool_uclacourserequestor']['nourlupdate_default'] = true;
$CFG->forced_plugin_settings['tool_uclacourserequestor']['nourlupdate_hide'] = true;

// Course Creator
//$CFG->forced_plugin_settings['tool_uclacoursecreator']['terms'] = $terms_to_built;
$CFG->forced_plugin_settings['tool_uclacoursecreator']['course_creator_email'] = 'ccle-operations@lists.ucla.edu';
$CFG->forced_plugin_settings['tool_uclacoursecreator']['email_template_dir'] = '';
$CFG->forced_plugin_settings['tool_uclacoursecreator']['make_division_categories'] = true;

// MyUCLA url updater
$CFG->forced_plugin_settings['tool_myucla_url']['url_service'] = 'https://test.ccle.ucla.edu/myucla_url_updater/update.php';  // test server
$CFG->forced_plugin_settings['tool_myucla_url']['user_name'] = 'CCLE Admin';   // name for registering URL with My.UCLA
$CFG->forced_plugin_settings['tool_myucla_url']['user_email'] = 'ccle@ucla.edu';  // email for registering URL with My.UCLA
$CFG->forced_plugin_settings['tool_myucla_url']['override_debugging'] = true;   // test sending MyUCLA urls

// For MyUCLA url updater phpunit tests.
define('MYUCLA_URL_UPDATER_TEST_CONFIG_URL',
        $CFG->forced_plugin_settings['tool_myucla_url']['url_service']);
define('MYUCLA_URL_UPDATER_TEST_CONFIG_NAME',
        $CFG->forced_plugin_settings['tool_myucla_url']['user_name']);
define('MYUCLA_URL_UPDATER_TEST_CONFIG_EMAIL',
        $CFG->forced_plugin_settings['tool_myucla_url']['user_email']);
define('MYUCLA_URL_UPDATER_TEST_CONFIG_OVERRIDE_DEBUGGING',
        $CFG->forced_plugin_settings['tool_myucla_url']['override_debugging']);
define('MYUCLA_URL_UPDATER_TEST_CONFIG_ACCESSDENIED_URL',
        'https://test.ccle.ucla.edu/myucla_url_updater/accessdenied.php');

// Pre-pop
//$CFG->forced_plugin_settings['enrol_database']['terms'] = $terms_to_built;

// turn off messaging (CCLE-2318 - MESSAGING)
$CFG->messaging = false;

// CCLE-2763 - Use new $CFG->divertallemailsto setting in 1.9 and 2.x
// development/testing environments
$CFG->divertallemailsto = 'ccle-email-test@lists.ucla.edu';

// CCLE-2306 - HELP SYSTEM BLOCK
// If using JIRA, jira_user, jira_password, jira_pid should be defined in config_private.php.
$CFG->forced_plugin_settings['block_ucla_help']['jira_endpoint'] = 'https://jira.ats.ucla.edu/rest/api/latest/issue';
$CFG->forced_plugin_settings['block_ucla_help']['docs_wiki_url'] = 'https://docs.ccle.ucla.edu/w/';
$CFG->forced_plugin_settings['block_ucla_help']['docs_wiki_api'] = 'https://docs.ccle.ucla.edu/api.php';
$block_ucla_help_support_contacts['System'] = 'support';  // Default.
$CFG->forced_plugin_settings['block_ucla_help']['maxfilesize'] = 10485760;
// CCLE-5879 Enable/disable the file attachement uploads for help ticket.
$CFG->forced_plugin_settings['block_ucla_help']['enablefileuploads'] = false;

// CCLE-2301 - COURSE MENU BLOCK
$CFG->forced_plugin_settings['block_ucla_course_menu']['trimlength'] = 22;

// UCLA Theme settings
$CFG->forced_plugin_settings['theme_uclashared']['running_environment'] = 'dev';
$CFG->cachejs = true;

// Prevent blocks from docking
$CFG->allowblockstodock = false;

// Newly created courses for ucla formats should only have the course menu block
$CFG->defaultblocks_ucla = 'ucla_course_menu';

// Enable conditional activities
$CFG->enableavailability = true;
$CFG->enablecompletion = true;  // needs to be enabled so that completion
                                // of tasks can be one of the conditions

// CCLE-2229 - Force public/private to be on
$CFG->enablegroupmembersonly = true; // needs to be on for public-private to work
$CFG->enablepublicprivate = true;

// CCLE-2792 - Enable multimedia filters
// NOTE: you still need to manually set the "Active?" value of the "Multimedia
// plugins" filter at "Site administration > Plugins > Filters > Manage filters"
$CFG->filter_mediaplugin_enable_youtube = true;
$CFG->filter_mediaplugin_enable_vimeo = true;
$CFG->filter_mediaplugin_enable_mp3 = true;
$CFG->filter_mediaplugin_enable_flv = true;
$CFG->filter_mediaplugin_enable_swf = false;    // security risk if enabled
$CFG->filter_mediaplugin_enable_html5audio = true;
$CFG->filter_mediaplugin_enable_html5video = true;
$CFG->filter_mediaplugin_enable_qt = true;
$CFG->filter_mediaplugin_enable_wmp = true;
$CFG->filter_mediaplugin_enable_rm = true;

// CCLE-2362 - MyUCLA Gradebook Integration
$CFG->gradebook_webservice = 'https://stage.cis.ucla.edu/ws/moodleitemgrade/service.svc?wsdl';
// this ID is discountinued, if you need a real gradebook_id, please contact
// the CCLE lead developer and assign it via your config_private.php file
$CFG->gradebook_id = 1;
$CFG->gradebook_password = '123';
$CFG->gradebook_send_updates = 0;

/// CCLE-2810 - My Sites - disallow customized "My Moodle" page
$CFG->forcedefaultmymoodle = true;

// to enable database unit testing
$CFG->unittestprefix = 'tst_';

// email address to notify in case of system problems
$CFG->forced_plugin_settings['local_ucla']['admin_email'] = 'ccle-operations@lists.ucla.edu';

// CCLE-3966 - Include self when messaging participants.
// Emails should still be sent to users that are logged in.
$CFG->forced_plugin_settings['message']['message_provider_moodle_instantmessage_loggedin'] = 'popup,email';

// CCLE-4345 - Moodle Authenticated Remote Command Execution (CVE-2013-3630).
//$CFG->preventexecpath = 1;

// CCLE-5959 - Disable Web Installations of Plugins
$CFG->disableupdateautodeploy = 1;

// Site administration > Advanced features
$CFG->usetags = 0;
$CFG->enablenotes = 0;
$CFG->enablewebservices = 1;
$CFG->bloglevel = 0; // Disable blog system completely
// CCLE-5181 Allow users to enter an alternate email
$CFG->messagingallowemailoverride = 1;
// CCLE-1266 - Enable RSS Feeds for Forum Posts
$CFG->enablerssfeeds = 1;

// Site administration > Users > Accounts > User default preferences
$CFG->defaultpreference_autosubscribe = 0;
$CFG->defaultpreference_trackforums = 1;

// Site administration > Users > Permissions > User policies
$CFG->autologinguests = true;
$CFG->showuseridentity = 'idnumber,email';
$CFG->hiddenuserfields = 'city,country,timezone,icqnumber,skypeid,yahooid,aimid,msnid';

// Site administration > Courses > Course default settings
$CFG->forced_plugin_settings['moodlecourse']['format'] = 'ucla';
$CFG->forced_plugin_settings['moodlecourse']['maxbytes'] = 2147483648;  // 2GB
// CCLE-2903 - Don't set completion tracking to be course default
$CFG->forced_plugin_settings['moodlecourse']['enablecompletion'] = 0;

// Site administration > Courses > Course request
$CFG->enablecourserequests = 1;

// Site administration > Courses > Backups > General backup defaults
// Commenting this out until following tracker issue is resolved:
// MDL-27886 - backup_general_users forbids all users to backup user data
//$CFG->forced_plugin_settings['backup']['backup_general_users'] = 0;
$CFG->forced_plugin_settings['backup']['backup_general_groups'] = 0;

// Site administration > Grades > General settings
$CFG->recovergradesdefault = 1;
$CFG->unlimitedgrades = 1;

// Site administration > Grades > Grade category settings
$CFG->grade_aggregation = 11; // Sets the Aggregation default to Simple weighted mean of grades.
$CFG->grade_aggregations_visible = '0,10,11,12,2,4,6,8,13'; // Enables all aggregation types.
$CFG->grade_overridecat = 0;

// Site administration > Grades > Report settings > Grader report
$CFG->grade_report_showeyecons = 0;
$CFG->grade_report_showanalysisicon = 0;
$CFG->grade_report_showuserimage = 0;
$CFG->grade_report_showcalculations = 1;

// CCLE-5445 - Default city and country
// Site administration > Location > Location settings
$CFG->defaultcity = 'Los Angeles';
$CFG->country = 'US';

// Site administration > Language > Language settings
$CFG->langstringcache = false;

// Site administration > Plugins > Activity modules > Assignment
$CFG->forced_plugin_settings['assign']['submissiondrafts'] = 1;
// CCLE-5193: Disable assignment module default student notification
$CFG->forced_plugin_settings['assign']['sendstudentnotifications'] = 0;

// Site administration > Plugins > Activity modules > Assignment > Submission plugins > Online PoodLL submissions
$CFG->forced_plugin_settings['assignsubmission_onlinepoodll']['allowedrecorders'] = '0,2';    // Allow only MP3 voice recorder and Video recorder.

// Site administration > Plugins > Activity modules > Book
$CFG->forced_plugin_settings['book']['requiremodintro'] = 0;

// Site administration > Plugins > Activity modules > Blackboard Collaborate Session
$CFG->elluminate_max_talkers = 2;

// Site administration > Plugins > Activity modules > Folder
$CFG->forced_plugin_settings['folder']['requiremodintro'] = 0;

// Site administration > Plugins > Activity modules > Forum
$CFG->forum_enablerssfeeds = 1;
$CFG->forum_enabletimedposts = 1;
$CFG->forum_rsstype = 2;
$CFG->forum_rssarticles = 5;

// Site administration > Plugins > Activity modules > IMS content package
$CFG->forced_plugin_settings['imscp']['requiremodintro'] = 0;

// Site administration > Plugins > Activity modules > Page
$CFG->forced_plugin_settings['page']['requiremodintro'] = 0;
$CFG->forced_plugin_settings['page']['printheading'] = 1;

// Site administration > Plugins > Activity modules > File
$CFG->forced_plugin_settings['resource']['requiremodintro'] = 0;
$CFG->forced_plugin_settings['resource']['printheading'] = 1;

// Site administration > Plugins > Activity modules > Quiz
$CFG->forced_plugin_settings['quiz']['overduehandling'] = 'autosubmit';

// Site administration > Plugins > Activity modules > Scheduler
$CFG->scheduler_maxstudentsperslot = 75;

// Site administration > Plugins > Activity modules > Turnitin Assignment (Legacy)
$CFG->turnitin_apiurl = 'https://api.turnitin.com/api.asp';
$CFG->turnitin_studentemail = 0;
$CFG->turnitin_tutoremail = 0;

// Site administration > Plugins > Activity modules > Turnitin Assignment
$CFG->forced_plugin_settings['turnitintooltwo']['useerater'] = 1;
$CFG->forced_plugin_settings['turnitintooltwo']['useanon'] = 1;
$CFG->forced_plugin_settings['turnitintooltwo']['inboxlayout'] = 1;

// Site administration > Plugins > Activity modules > URL
$CFG->forced_plugin_settings['url']['requiremodintro'] = 0;
$CFG->forced_plugin_settings['url']['displayoptions'] = '0,1,2,3,4,5,6';    // allow every option
$CFG->forced_plugin_settings['url']['printheading'] = 1;
$CFG->forced_plugin_settings['url']['display'] = 3; // RESOURCELIB_DISPLAY_NEW
$CFG->forced_plugin_settings['url']['enableuservar'] = 0;

// Site administration > Plugins > Activity modules > Video Annotation
// You will need to have the same number of elements in tnawebserviceurl as tnapermalinkurl.
$CFG->tnawebserviceurl = array("http://tvnews.sscnet.ucla.edu/webservice/edge/webservice.php",
                               "http://tvnews.sscnet.ucla.edu/webservice/edge/webservice.php",
                               "http://tvnews.sscnet.ucla.edu/webservice/edge/webservice.php",
                               "http://tvnews.sscnet.ucla.edu/webservice/edge/webservice.php",
                               "http://tvnews.sscnet.ucla.edu/webservice/edge/webservice.php",
                               "http://newsscape.library.ucla.edu/util/webservice.php",
                               "https://tvnews.sscnet.ucla.edu/webservice/edge/webservice.php");
$CFG->tnapermalinkurl = array("http://www.sscnet.ucla.edu/tna/setesting/video,",
                              "http://www.sscnet.ucla.edu/tna/edge/video,",
                              "http://www.sscnet.ucla.edu/csa/search/video,",
                              "http://dcl.sscnet.ucla.edu/search/video,",
                              "http://tvnews.library.ucla.edu/video,",
                              "http://newsscape.library.ucla.edu/video,",
                              "https://tvnews.sscnet.ucla.edu/edge/video,");
$CFG->tnastreamerurl = "rtmp://169.232.194.193/csa";

// Site administration > Plugins > Assignment plugins > Submission plugins > File submissions
$CFG->forced_plugin_settings['assignsubmission_file']['maxfiles'] = 50;
$CFG->forced_plugin_settings['assignsubmission_file']['maxbytes'] = 104857600;   // 100MB

// Site administration > Plugins > Assignment plugins > Feedback plugins > Feedback PoodLL
$CFG->forced_plugin_settings['assignfeedback_poodll']['default'] = 0;

// Site administration > Plugins > Assignment plugins > Feedback plugins > Feedback comments
$CFG->forced_plugin_settings['assignfeedback_comments']['default'] = 1;

// Site administration > Plugins > Assignment plugins > Feedback plugins > File feedback
$CFG->forced_plugin_settings['assignfeedback_file']['default'] = 1;

// Site administration > Plugins > Admin tools > Merge user accounts
$CFG->forced_plugin_settings['tool_mergeusers']['quizattemptsaction'] = 'renumber';

// Site administration > Plugins > Admin tools > Recycle bin
$CFG->forced_plugin_settings['tool_recyclebin']['coursebinexpiry'] = 1209600;
$CFG->forced_plugin_settings['tool_recyclebin']['categorybinexpiry'] = 1209600;
$CFG->forced_plugin_settings['tool_recyclebin']['autohide'] = 0;

// Site administration > Plugins > Enrollments > UCLA registrar
$CFG->forced_plugin_settings['local_ucla']['overrideenroldatabase'] = 1;

// Site administration > Plugins > Enrollments > Guest access
$CFG->forced_plugin_settings['enrol_guest']['defaultenrol'] = 1;
$CFG->forced_plugin_settings['enrol_guest']['status'] = 0;  // 0 is yes, 1 is no

// Site administration > Plugins > Enrollments > Site invitation
$CFG->forced_plugin_settings['enrol_invitation']['status'] = 0; // ENROL_INSTANCE_ENABLED.
$CFG->forced_plugin_settings['enrol_invitation']['enabletempparticipant'] = 1;

// Site administration > Plugins > Enrollments > Self enrolment
$CFG->forced_plugin_settings['enrol_self']['defaultenrol'] = 0;
$CFG->forced_plugin_settings['enrol_self']['status'] = 1;  // 0 is yes, 1 is no
$CFG->forced_plugin_settings['enrol_self']['sendcoursewelcomemessage'] = 0;

// Site administration > Plugins > Blocks > UCLA bruincast
$CFG->forced_plugin_settings['block_ucla_bruincast']['source_url'] = 'http://www2.oid.ucla.edu/help/info/bcastlinks/';
$CFG->forced_plugin_settings['block_ucla_bruincast']['errornotify_email'] = 'ccle-operations@lists.ucla.edu';
$CFG->forced_plugin_settings['block_ucla_bruincast']['quiet_mode'] = 1;

// Site administration > Plugins > Blocks > UCLA bruinmedia
$CFG->forced_plugin_settings['block_ucla_bruinmedia']['source_url'] = 'http://www2.oid.ucla.edu/help/info/bmedialinks.csv';
$CFG->forced_plugin_settings['block_ucla_bruinmedia']['errornotify_email'] = 'ccle-operations@lists.ucla.edu';
$CFG->forced_plugin_settings['block_ucla_bruinmedia']['quiet_mode'] = 1;

// Site administration > Plugins > Blocks > UCLA course download
$CFG->forced_plugin_settings['block_ucla_course_download']['student_access_begins_week'] = 9;
// CCLE-5582 - Decrease maxfile size to 250
$CFG->forced_plugin_settings['block_ucla_course_download']['maxfilesize'] = 250;

// Site administration > Plugins > Blocks > UCLA library reserves
$CFG->forced_plugin_settings['block_ucla_library_reserves']['source_url'] = 'ftp://ftp.library.ucla.edu/incoming/eres/voyager_reserves_data.txt';

// Site administration > Plugins > Blocks > TA sites
$CFG->forced_plugin_settings['block_ucla_tasites']['enablebysection'] = 0;

// Site administration > Plugins > Blocks > UCLA video reserves
$CFG->forced_plugin_settings['block_ucla_video_reserves']['sourceurl'] = 'ftp://guest:access270@164.67.141.31//Users/guest/Sites/MEDIA_LINKS.txt';

// Data Source Sync (bruincast, video reserves, library reserves) contact Email
$CFG->forced_plugin_settings['tool_ucladatasourcesync']['contact_email']='ccle-operations@lists.ccle.ucla.edu';

// Site administration > Plugins > Blocks > i>clicker Moodle integrate
$CFG->forced_plugin_settings['block_iclicker']['block_iclicker_notify_emails'] = 'ccle-operations@lists.ucla.edu';
$CFG->block_iclicker_notify_emails = 'ccle-operations@lists.ucla.edu';  // due to bad coding, two variables exist to do the same thing
$CFG->forced_plugin_settings['block_iclicker']['block_iclicker_enable_shortname'] = 1;

// Site administration > Plugins > Blocks > Quickmail
$CFG->block_quickmail_allowstudents = -1;
$CFG->block_quickmail_receipt = 1;
$CFG->block_quickmail_addionalemail = 1;

// Site administration > Plugins > Blocks > UCLA Media
$CFG->forced_plugin_settings['block_ucla_media']['library_source_url'] = 'https://webservices-test.library.ucla.edu/music/v2/classes';

// Site administration > Plugins > Licences > Manage licences
$CFG->sitedefaultlicense = 'tbd';

// Site administration > Plugins > Filters > MathJax
$CFG->forced_plugin_settings['filter_mathjaxloader']['texfiltercompatibility'] = 1;
$CFG->forced_plugin_settings['filter_mathjaxloader']['mathjaxconfig'] = '
    MathJax.Hub.Config({
        tex2jax: {
            inlineMath: [[\'$\',\'$\'], [\'\\\(\',\'\\\)\']],
            processEscapes: true
        },
        config: ["MMLorHTML.js", "Safe.js"],
        jax: ["input/TeX","input/MathML","output/HTML-CSS","output/NativeMML"],
        extensions: ["tex2jax.js","mml2jax.js","MathMenu.js","MathZoom.js"],
        TeX: {
            extensions: ["mhchem.js","AMSmath.js","AMSsymbols.js","noErrors.js","noUndefined.js"]
        },
        menuSettings: {
            zoom: "Double-Click",
            mpContext: true,
            mpMouse: true
        },
        errorSettings: { message: ["!"] },
        skipStartupTypeset: true,
        messageStyle: "none"
    });';

// Site administration > Plugins > Filters > OID Wowza filter
$CFG->filter_oidwowza_enable_mp4 = 1;

// Site administration > Plugins > Filters > PoodLL Filter
$CFG->filter_poodll_download_media_ok = '1';
$CFG->filter_poodll_miccanpause = '1';

// Site administration > Plugins > Repositories > Common repository settings
$CFG->legacyfilesinnewcourses = 1;  // enable new course to enable legacy course files

// Site administration > Plugins > Text editors > Atto HTML editor > Atto toolbar settings
$CFG->forced_plugin_settings['editor_atto']['toolbar'] = '
    collapse = collapse
    style1 = fontfamily, title, bold, italic, underline, backcolor, fontcolor, count
    list = unorderedlist, orderedlist
    indent = indent
    undo = undo
    pastespecial = pastespecial
    links = link
    files = image, media, managefiles, kalturamedia, mediagallery
    other = htmlplus, fullscreen
    style2 = strike, subscript, superscript
    align = align, table, bsgrid
    insert = chemrender, chemistry, computing, equation, poodll, charmap, clear
    accessibility = accessibilitychecker, accessibilityhelper';

// CCLE-4849 - Number of groups displayed on first row of Atto HTML Editor
$CFG->forced_plugin_settings['atto_collapse']['showgroups'] = 8;

// Site administration > Plugins > Text editors > Atto HTML editor > Font family setting
$CFG->forced_plugin_settings['atto_fontfamily']['fontselectlist'] = '
    Default=Lato, Helvetica Neue, Helvetica, Arial, sans-serif;
    Arial=Arial, Helvetica, sans-serif;
    Times=Times New Roman, Times, serif;
    Courier=Courier New, Courier, mono;
    Georgia=Georgia, Times New Roman, Times, serif;
    Verdana=Verdana, Geneva, sans-serif;
    Trebuchet=Trebuchet MS, Helvetica, sans-serif;';

// Site administration > Plugins > Text editors > TinyMCE HTML editor > General settings
$CFG->forced_plugin_settings['editor_tinymce']['customtoolbar'] = '
    wrap,formatselect,wrap,bold,italic,wrap,bullist,numlist,wrap,link,unlink,wrap,image, mediagallery

    undo,redo,wrap,underline,strikethrough,sub,sup,wrap,justifyleft,justifycenter,justifyright,wrap,outdent,indent,wrap,forecolor,backcolor,wrap,ltr,rtl,

    nonbreaking, poodllaudiomp3, poodllvideo, poodllwhiteboard, poodllsnapshot, charmap,table

    fontselect,fontsizeselect,code,search,replace,wrap,cleanup,removeformat,pastetext,pasteword,wrap,fullscreen';

// Site administration > Plugins > Text editors > TinyMCE HTML editor > Insert equation
$CFG->forced_plugin_settings['tinymce_dragmath']['requiretex'] = 0;

// Site administration > Plugins > Local plugins > Kaltura Media Gallery.
$CFG->forced_plugin_settings['local_kalturamediagallery']['link_location'] = '1';   // Course settings.

// Site administration > Plugins > Local plugins > Moodle Mobile additional features.
$CFG->forced_plugin_settings['local_mobile']['typeoflogin'] = 2;    // Via a browser window (for SSO plugins).

// Site administration > Plugins > Local plugins > UCLA customizations.
$CFG->forced_plugin_settings['local_ucla']['registrar_cache_ttl'] = 3600;   // 1 hour
$CFG->forced_plugin_settings['local_ucla']['regsyllabustable'] = 'ucla_syllabus_test';
$CFG->forced_plugin_settings['local_ucla']['handlepreferredname'] = 1; // CCLE-4521 - Handle "preferred name".

// SSC-2050 - Sets limit to number of crosslisted course displayed in forum email header
$CFG->forced_plugin_settings['local_ucla']['limitcrosslistemail'] = 2;

// Grading config variables.
// CCLE-4295 - Add Grouping Filter for the Grader Report
$CFG->grader_report_grouping_filter = 1;
// CCLE-4297 - Have "quick grading" turned on by default
$CFG->forced_plugin_settings['local_ucla']['defaultassignquickgrading'] = 1;
// CCLE-4289 - Show All View Action Icons
$CFG->forced_plugin_settings['local_ucla']['showallgraderviewactions'] = 1;

// Site administration > Plugins > Message outputs > Email
$CFG->emailonlyfromnoreplyaddress = 1;

// Site administration > Plugins > Web services > Mobile
$CFG->enablemobilewebservice = 1;

// Site administration > Security > Site policies
$CFG->forceloginforprofiles = true;
$CFG->forceloginforprofileimage = true; // temporary until "CCLE-2368 - PIX.PHP security fix" is done
$CFG->allowobjectembed = 1;
$CFG->maxeditingtime = 900; // 15 minutes
$CFG->fullnamedisplay = 'lastname, firstname';
$CFG->cronclionly = true;
// Make it easier to create accounts on dev instances.
$CFG->minpasswordlength = 4;
$CFG->minpassworddigits = 0;
$CFG->minpasswordupper = 0;
$CFG->minpasswordnonalphanum = 0;

// Site administration > Appearance > Themes
$CFG->theme = 'uclashared';

// Site administration > Appearance > Themes > Theme settings
$CFG->themelist = "uclashared,uclasharedcourse";
$CFG->themedesignermode = 0;
$CFG->allowcoursethemes = 1;
$CFG->custommenuitems = "Submit a help request|/blocks/ucla_help/index.php
    View self help articles|https://docs.ccle.ucla.edu/
    Read tips & updates|https://docs.ccle.ucla.edu/w/Tips_and_Updates
    Request a site|/course/request.php";
$CFG->customusermenuitems = "grades,grades|/grade/report/mygrades.php|grades
preferences,moodle|/user/preferences.php|preferences";

// Site administration > Appearance > Navigation
$CFG->defaulthomepage = 1;    // user's home page should be "My Moodle" (HOMEPAGE_MY)
$CFG->navshowcategories = 0;

// Site administration > Appearance > Courses
$CFG->courselistshortnames = 1;

// Site administration > Server > Session handling
$CFG->dbsessions = false;

// Site administration > Development > Experimental > Experimental settings
$CFG->dndallowtextandlinks = 1;
$CFG->enabletgzbackups = 1;

// Site administration > Development > Debugging
$CFG->debug = 32767;    // DEVELOPER level debugging messages
$CFG->debugdisplay = 1;  // show the debugging messages
$CFG->perfdebug = 15; // show performance information
$CFG->debugpageinfo = 1; // show page information

// If you want to have un-revisioned configuration data, place in config_private
// $CFG->dirroot is overwritten later
$_dirroot_ = dirname(realpath(__FILE__)) . '/../../..';
$_config_private_ = $_dirroot_ . '/config_private.php';
if (file_exists($_config_private_)) {
    require_once($_config_private_);
}

// Site administration > Plugins > Enrolments > External database
// set external database connection settings after config_private.php has
// been read for the Registrar connection details
$CFG->forced_plugin_settings['enrol_database']['dbtype'] = $CFG->registrar_dbtype;
$CFG->forced_plugin_settings['enrol_database']['dbhost'] = $CFG->registrar_dbhost;
$CFG->forced_plugin_settings['enrol_database']['dbuser'] = $CFG->registrar_dbuser;
$CFG->forced_plugin_settings['enrol_database']['dbpass'] = $CFG->registrar_dbpass;
$CFG->forced_plugin_settings['enrol_database']['dbname'] = '';
$CFG->forced_plugin_settings['enrol_database']['remoteenroltable'] = 'enroll2_test';
$CFG->forced_plugin_settings['enrol_database']['remotecoursefield'] = 'termsrs';
$CFG->forced_plugin_settings['enrol_database']['remoteuserfield'] = 'uid';
$CFG->forced_plugin_settings['enrol_database']['remoterolefield'] = 'role';
$CFG->forced_plugin_settings['enrol_database']['localcoursefield'] = 'id';
$CFG->forced_plugin_settings['enrol_database']['localrolefield'] = 'id';
$CFG->forced_plugin_settings['enrol_database']['localuserfield'] = 'idnumber';
$CFG->forced_plugin_settings['enrol_database']['unenrolaction'] = 2;    // ENROL_EXT_REMOVED_SUSPEND

// CCLE-2364 - SUPPORT CONSOLE (put after $_dirroot_, because needs $CFG->dataroot to be set)
$CFG->forced_plugin_settings['tool_uclasupportconsole']['log_apache_error'] = '/var/log/httpd/error_log';
$CFG->forced_plugin_settings['tool_uclasupportconsole']['log_apache_access'] = '/var/log/httpd/access_log';
$CFG->forced_plugin_settings['tool_uclasupportconsole']['log_apache_ssl_access'] = '/var/log/httpd/ssl_access_log';
$CFG->forced_plugin_settings['tool_uclasupportconsole']['log_apache_ssl_error'] = '/var/log/httpd/ssl_error_log';
$CFG->forced_plugin_settings['tool_uclasupportconsole']['log_apache_ssl_request'] = '/var/log/httpd/ssl_request_log';
$CFG->forced_plugin_settings['tool_uclasupportconsole']['log_course_creator'] = $CFG->dataroot . '/course_creator/';

// Enable customscripts for Respondus and other UCLA custom changes.
// NOTE: config is in local/ucla/configs, even though it is linked in root.
$CFG->customscripts = $_dirroot_ . "/local/ucla/customscripts";

/////////

$CFG->dbtype    = getenv('MOODLE_DOCKER_DBTYPE');
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'db';
$CFG->dbname    = getenv('MOODLE_DOCKER_DBNAME');
$CFG->dbuser    = getenv('MOODLE_DOCKER_DBUSER');
$CFG->dbpass    = getenv('MOODLE_DOCKER_DBPASS');
// $CFG->prefix    = 'm_';
$CFG->prefix    = 'mdl_';

//$CFG->dboptions = ['dbcollation' => getenv('MOODLE_DOCKER_DBCOLLATION')];
$CFG->dboptions['dbpersist'] = 0;
$CFG->dboptions['dbsocket']  = 1;
$CFG->dboptions['dbcollation'] = 'utf8mb4_unicode_ci';
$CFG->dboptions['dbcollation'] = getenv('MOODLE_DOCKER_DBCOLLATION');

//$CFG->wwwroot   = 'http://localhost';
$CFG->wwwroot = 'http://192.168.99.100';
$port = getenv('MOODLE_DOCKER_WEB_PORT');
if (!empty($port)) {
    $CFG->wwwroot .= ":{$port}";
}
$CFG->dataroot  = '/var/www/moodledata';
$CFG->admin     = 'admin';
$CFG->directorypermissions = 0777;
$CFG->smtphosts = 'mailhog:1025';

// Debug options - possible to be controlled by flag in future..
$CFG->debug = (E_ALL | E_STRICT); // DEBUG_DEVELOPER
$CFG->debugdisplay = 1;
$CFG->debugstringids = 1; // Add strings=1 to url to get string ids.
$CFG->perfdebug = 15;
$CFG->debugpageinfo = 1;
$CFG->allowthemechangeonurl = 1;
$CFG->passwordpolicy = 0;

$CFG->phpunit_dataroot  = '/var/www/phpunitdata';
$CFG->phpunit_prefix = 't_';

$CFG->behat_wwwroot   = 'http://webserver';
$CFG->behat_dataroot  = '/var/www/behatdata';
$CFG->behat_prefix = 'b_';
$CFG->behat_profiles = array(
    'default' => array(
        'browser' => getenv('MOODLE_DOCKER_BROWSER'),
        'wd_host' => 'http://selenium:4444/wd/hub',
    ),
);
$CFG->behat_faildump_path = '/var/www/behatfaildumps';

define('PHPUNIT_LONGTEST', true);

if (getenv('MOODLE_DOCKER_PHPUNIT_EXTRAS')) {
    define('TEST_SEARCH_SOLR_HOSTNAME', 'solr');
    define('TEST_SEARCH_SOLR_INDEXNAME', 'test');
    define('TEST_SEARCH_SOLR_PORT', 8983);

    define('TEST_SESSION_REDIS_HOST', 'redis');
    define('TEST_CACHESTORE_REDIS_TESTSERVERS', 'redis');

    define('TEST_CACHESTORE_MONGODB_TESTSERVER', 'mongodb://mongo:27017');

    define('TEST_CACHESTORE_MEMCACHED_TESTSERVERS', "memcached0:11211\nmemcached1:11211");
    define('TEST_CACHESTORE_MEMCACHE_TESTSERVERS', "memcached0:11211\nmemcached1:11211");

    define('TEST_LDAPLIB_HOST_URL', 'ldap://ldap');
    define('TEST_LDAPLIB_BIND_DN', 'cn=admin,dc=openstack,dc=org');
    define('TEST_LDAPLIB_BIND_PW', 'password');
    define('TEST_LDAPLIB_DOMAIN', 'ou=Users,dc=openstack,dc=org');

    define('TEST_AUTH_LDAP_HOST_URL', 'ldap://ldap');
    define('TEST_AUTH_LDAP_BIND_DN', 'cn=admin,dc=openstack,dc=org');
    define('TEST_AUTH_LDAP_BIND_PW', 'password');
    define('TEST_AUTH_LDAP_DOMAIN', 'ou=Users,dc=openstack,dc=org');

    define('TEST_ENROL_LDAP_HOST_URL', 'ldap://ldap');
    define('TEST_ENROL_LDAP_BIND_DN', 'cn=admin,dc=openstack,dc=org');
    define('TEST_ENROL_LDAP_BIND_PW', 'password');
    define('TEST_ENROL_LDAP_DOMAIN', 'ou=Users,dc=openstack,dc=org');
}

require_once('/var/www/html/lib/setup.php');
