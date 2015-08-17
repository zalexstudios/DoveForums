# DoveForums

Dove Forums is a brand new Bulletin Board software build from scratch on top of the Codeigniter & Twitter Bootstrap frameworks.

After nearly 3 years away from development due to work and home life, I have decided to give this project another go, this time making it Open Source to allow the community to also work on it.

The project goal is a simple one.  To make Bulletin Board software that is easy to use, install and customize and best of all Free!.  I am also trying to keep as much as I can native to CI without having too many external libraries cluttering up the code.  The following external libraries are going to be used as a starting point:

- <a href="http://www.benedmunds.com">Ben Edmunds</a> - Ion Auth
- <a href="http://www.ericlbarnes.com">Eric Barnes</a> - Slug & Settings
- <a href="http://www.kylenoland.com">Kyle Noland</a> - MessageCI
- <a href="http://www.irealms.co.uk">Ryan Marshal</a> - Gravatar
- <a href="https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg">schnawel007</a> - bootstrap3-wysiwyg

Thank you to all mentioned above for the great work on these libraries. 

<h2>Installation</h2>

This project now has a built in installer.  Simply download this repo, place in your localhost / webhost and run :-

http://www.yoursite.com

You will automatically be taken to the installer.

<h2>Demo</h2>

You can view the demo over at http://www.doveforums.com/beta/

This project is also been built on top of the latest Codeigniter & Twitter Bootstrap builds.  

If you would like to contribute to this project that would be great as I really would like to get this project back on track after so much time away from the community.

<h2>Email Settings</h2>

Version 0.5.0 adds Email Notifications.  I have only tested with with SMTP emails up to now.  I personally recommend <a href="https://sendgrid.com">SendGrid</a> as your SMTP host if you are unsure how to go about setting this up yourself.

Sign up for a <strong>Free</strong> account, then log into your Dove Forums install with your administrator account, go to Dashboard->Settings and then enter the following information into the <strong>Email</strong> section :-

<ul>
<li>Protocol - smtp</li>
<li>Smtp Host - smtp.sendgrid.net</li>
<li>Smtp User - sendgridusername</li>
<li>Smtp Pass - sendgridpassword</li>
<li>Smtp Port - 587</li>
</ul>

After this information is entered click '<strong>Update Settings</strong>' and that's it!

Regards
Chris

<hr />

<h2>Todo</h2>

Frontend :-

<ul>
<li>User Profile Function</li>
<li>User Settings Function</li>
<li><strike>User Change Password Function</strike> - Commit #65</li>
<li><strike>User Forgot Password Function</strike> - Commit #65</li>
<li>Send PM Function</li>
<li>Thumbs Up Function</li>
<li><strike>Delete Discussion Function</strike> - Commit #56</li>
<li><strike>Edit Discussion Function</strike> - Commit #61</li>
<li><strike>Report Discussion Function</strike> - Commit #63</li>
<li><strike>Delete Comments Function</strike> - Commit #61</li>
<li><strike>Edit Comment Function</strike> - Commit #61</li>
<li><strike>Report Comment Function</strike> - Commit #63</li>
</ul>

Backend :-

<ul>
<li>All Discussions Function</li>
<li><strike>All Groups Function</strike> - Commit #83</li>
<li><strike>Add Group Function</strike> - Commit #83</li>
<li><strike>Edit Group Function</strike> - Commit #83</li>
<li><strike>Delete Group Function</strike> - Commit #83</li>
<li>Settings Function</li>
<li>View User Function</li>
<li>View Category Function</li>
<li>View Group Function</li>
</ul>

Other :-

<ul>
<li><strike>Installation Function</strike> - Commit #70</li>
</ul>
