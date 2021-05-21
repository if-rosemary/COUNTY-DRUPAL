Washington County, OR // Site Redesign Project
====

Drupal 9 [County Site](https://www.co.washington.or.us) redesign project for Washington County, Oregon.

Hosted on Acquia Cloud Platform.
Developed on Acquia Cloud IDE.

## Contents
[Cloud IDE setup](#cloud-ide-setup)

[Starting a new story branch](#starting-a-new-story-branch)

[Daily workflow](#daily-workflow)

[Completing and deploying your story item](#completing-and-deploying-your-story-item)

[QA workflow](#qa-workflow)

&nbsp;&nbsp;&nbsp;&nbsp; [QA process](#qa-process)

## Cloud IDE setup

<details><summary>Expand for details</summary><p>

1. Create your Acquia Cloud IDE. This will be covered in a separate document (linked here soon).

2. Fork the *Washington-County / COUNTY-DRUPAL* repository (repo) to your own GitHub account.

	Login to your GitHub account, visit the [primary repo GitHub page](https://github.com/Washington-County/COUNTY-DRUPAL) and click the ***Fork*** button. (This will later be referred to as the **upstream** repository.)

3. Open your Acquia Cloud IDE. **Be sure** to click the **Configure IDE** button displayed to setup your initial SSH keys to connect you to Cloud Platform. (We've had mixed success doing this manually from terminal.)

	Visit the [API Tokens](https://cloud.acquia.com/a/profile/tokens) page and create a token named "Acquia Cloud IDE". Leave this window open.

	When prompted, copy and paste the API key and secret from your browser to the terminal within Cloud IDE. A confirmation will appear that credentials were saved.

4. For a new Cloud IDE instance, you will need to create an SSH key that can be used to access Acquia Cloud Platform and GitHub.  Click either link to expand instructions.

	<details><summary>Acquia Cloud Platform</summary><p>

	a. Enter this command in Cloud IDE Terminal:

	``` ssh-keygen -b 4096 -C [your_email]@co.washington.or.us ```

	b. You'll be prompted to *Enter the file in which to save the key (/home/ide/.ssh/id_rsa):* -- enter the following full path with adjusted filename:

	``` /home/ide/.ssh/id_rsa_acp ```

	c. You'll be prompted to enter a passphrase. You can simply **press Enter** to bypass this.

	d. Enter the following command:

	``` ls ~/.ssh ```

	You should see the presence of files "id_rsa_acp" and
"id_rsa_acp.pub".

	e. Now enter:

	``` cat ~/.ssh/id_rsa_acp.pub ```

	All the text that appears (starting with "ssh" and ending with your e-mail address) should be highlighted and copied to the clipboard (Ctrl+C). **Be sure not to highlight any additional characters or spaces before copying.**

	f. Open your individual Acquia Cloud Platform [SSH
Keys](https://cloud.acquia.com/a/profile/ssh-keys) page. Click the **Add SSH Key** button. Give the new key a title (e.g. "Your Name - Acquia Cloud IDE"), then paste the public key text into the Public Key field and save. The new key should appear in your list of keys.</p></details>

	<details><summary>GitHub</summary><p>

	a. Make sure you've already created a GitHub account, and then use whichever email account is assigned to your established GitHub account. Start by entering this command in Cloud IDE Terminal:

	``` ssh-keygen -t ed25519 -C "[your_email]@co.washington.or.us" ```

	b. You'll be prompted to *Enter the file in which to save the
key (/home/ide/.ssh/id_ed25519):* -- just **press Enter** to accept the default.

	  c. You'll be prompted to enter a passphrase. You can simply **press Enter** to bypass this.

	d. Enter the following command:

	``` ls ~/.ssh\ ```

	You should see the presence of files "id_ed25519" and "id_ed25519.pub".

	e. Now enter:

	``` cat ~/.ssh/id_ed25519.pub ```

	All the text that appears (starting with "ssh" and ending with your e-mail address) should be highlighted and copied to the clipboard (Ctrl+C). **Be sure not to highlight any additional characters or spaces before copying.**

	f. Go back to [GitHub Keys](https://github.com/settings/keys) page. Click the **New SSH key** button. Give the new key a title like "Acquia Cloud IDE", then paste the public key text into the body and save. The new key should appear in your list of keys.

	g. Test your SSH-based connection to GitHub with

	``` ssh -T git@github.com ```

	(Make sure the switch is a capital "-T".)

	GitHub should respond with a "Hi *[username]*" greeting.</p></details>


5. Setup your email address for Git in your IDE and for GitHub.

    - Check [GitHub email settings](https://github.com/settings/emails) for your account and confirm that one or more appropriate email addresses are set. (Note that you have the option to *Keep my email addresses private* lower on the page. Decide if this is desired and check the box accordingly -- this will be important in the next step.)
    
    - Set an email address for Git in your local IDE that matches either one of your account email addresses, or the *private* GitHub email address provided by the *Keep my email addresses private* option (e.g. 9876234+*username*@users.noreply.github.com). 
    
        Run the following command:
        
        ``` git config --global user.email "email@example.com" ```
        
        You can confirm to check what email address is now associated with your IDE Git instance:
        
        ``` git config --global user.email ```

        The email address you just set should be displayed.
        
    For further guidance on this topic, check the GitHub help page on [setting your commit email address](https://docs.github.com/en/github/setting-up-and-managing-your-github-user-account/setting-your-commit-email-address).

5. Initialize your local git repo in your IDE. This will create a hidden folder called ".git" where your local git data will live.

	``` git init ```

6. Define your remote repositories. "Origin" will be your forked repository, and "upstream" will be the primary WashCo repository.

	``` 
	git remote add origin git@github.com:[your-GitHub-username]/COUNTY-DRUPAL.git
	git remote add upstream git@github.com:Washington-County/COUNTY-DRUPAL.git 
	```

7. Verify remote repos (origin and upstream) are correctly linked from your local IDE:

	``` git remote -v ```

8. Since your prompt should show you've checked out the master branch, let's retrieve the contents of the origin master branch to be current there. (We use this method rather than git clone because it allows you to treat \~/project as your actual project root, simplifying things.)

	``` git pull ```

	(You may see a message stating "The authenticity of host 'github.com *(IP)*' can't be established. Are you sure you want to continue connecting?". Answer "yes".)

9. Checkout your develop branch.
	
    ``` git checkout develop ```	
	
10. Run an initial Composer install to ensure BLT tools are active.
	
    ``` composer install ```	
	
11. Now, run our custom BLT "catchup" command. It will locally checkout develop branch, pull the latest code from the develop branch of the primary (upstream) repo, pull the database from the dev environment, use Composer to install dependencies, and deploy the site (```drush deploy``` incorporates a config import, resulting database updates, cache clear, and deploy hook). 

    ``` blt custom:catchup ```

    Then, for a first-time setup, also run the BLT source build.
    
	``` blt source:build ```

</p></details>


## Starting a new story branch

**Do not do this if you are still working on another feature or story activity.**

**Work one story at a time to completion.**

  1. To start developing a story item, you will first want to refresh your local dev site with recent changes from the main Dev site (so this applies unless you literally just finished with "First-time setup").
  
        Again, our custom BLT command will handle all activities to catchup with main Dev environment (as described in the prior section):

		```	blt custom:catchup ```

		(It is possible that a nano editing session may appear for you to enter a merge commit message -- you can just press **Ctrl+X** to exit nano, and the default message will be entered.)

2. Now, checkout your new story branch. The branch name convention is ***activity/story-id***. Possible activities include:

	- feature (actual functionality development)
	- hotfix (short-fuse correction of an issue)
	- bugfix (fix a bug)
	- spike (experimentation in support of research)

	Enter the following:
	
	``` git checkout -b feature/[story-id] ```
	
	*(story ID in the format: STRY0012345)*

3. You will probably need to login as admin at some point to your local dev site. Use ```drush uli``` to get a one-time login link, and Ctrl+click the link.

	(If this results in a "Temporarily Unavailable" error from accounts.acquia.com, try signing into cloud.acquia.com again in your browser before using the link.)

4. Work on the story item. Jump down to the ***Daily workflow*** section for specific daily actions.

	**IMPORTANT**: Remember the difference between content and configuration data as you work. For example, if you create a taxonomy, any terms you add to your local dev site will not propagate to the general dev site or beyond.

	***Types*** of things (e.g. a taxonomy, content type, user *role*, etc) are configuration, and are thought of as code thanks to ```drush cex```.

	Code only moves *upstream* and content (DB & files) only moves *downstream* through environments. Any content you create in local dev (for example, to test a feature) will not be conveyed past local dev.

5. Once development is complete, follow the instructions in ***Completing and deploying your story item***.

## Daily workflow

1. Make changes to your local dev site.

2. Stage those changes for the next commit to your local story branch on Cloud IDE, and then commit them. (This can be done multiple times a day, or just once at the end.)

	a. First, you must export configuration items living in the database to YAML code files. (Answer "yes" when prompted to delete and replace existing config export files.)

	``` drush cex ```

	b. Do a git status check:

	``` git status ```

	Observe the files in red -- these are new or modified files that have not yet been ```git add```-ed to the upcoming commit to your story branch.\

	Determine which of these files should be added to your story branch. (Not all files will need to be tracked with the story branch changes -- in some cases, you may want to skip tracking of certain files.)

	c. Add any untracked files relevant to your story branch that will become part of the next commit.

	``` git add . ```

	The period ```.``` indicates that all files below the current folder will be included. (Your prompt should display ```~/project``` as the current folder.)

	d. Commit the changes you've staged to your local Cloud IDE story branch. Use "WCOR-" and the story ID number at the start of your commit message (e.g. WCOR-0012345). Write your commit message in present tense starting with an action verb to describe the latest round of changes. Example:

	``` git commit -m "WCOR-[story-ID-number]: Add content type Page." ```

	e. When you first push your branch to your origin (forked repo) develop branch:
	
	```  git push -u origin [story-branch-name] ```
	
	(The -u option would allow you to simply use ```git push``` on your next push, without specifying that you're pushing your story branch to origin.)


## Completing and deploying your story item

1. Do a final ``` git status ``` to ensure no further changes have occurred since your prior commit. If there are any red-text items, run through the [*Daily workflow*](#daily-workflow) steps again before proceeding.

2. Take one last opportunity to execute the existing test plan (from the ServiceIT story acceptance criteria field) in your local dev site. You are likely to find that the plan could use more specific detail to ensure a quality result. Update the test plan accordingly.

3. When the feature or story item is considered complete, create and submit a pull request (PR).

	a. In a browser, open the PR for the merge of your new feature/story branch into the primary/canonical (upstream) develop branch. 
	
	You'll see an alert about it at the top of your forked repo GitHub page:

	*https[]()://github.com/[your-GitHub-username]/COUNTY-DRUPAL*

	b. Click the **Compare & pull request** button. Confirm the PR title, and enter a comment if desired. Then click **Create pull request**. The new PR page will load.
	
	c. Pull requests must have an approving review from Code Review and QA in order to proceed. Add the Build Coordinator to the *Reviewers* section of the right sidebar on the PR page now. (QA is self-assigned, so the DigEx member picking up QA for the item will add themself later as a reviewer for your PR.)

	d. Scrolling down, you will see the status of the PR:

	- **Review** will tell you whether the PR has been reviewed and approved.

	- **Checks** will tell you whether Cloud Platform Pipelines has successfully tested the new branch.

	- **Merge** will tell you whether the new branch was merged with the primary (upstream) develop branch.

4. Acquia Pipelines will run against the newly submitted PR. This includes a number of automated technical checks along with any Behat tests that have been written. 

    - If Pipelines **did not** run successfully, it is because:
    
        - There is an issue with your code.
    
        - There are no additional CD environments for Pipelines to create (the current maximum is 3).
    
        Proceed as follows:
        
        a. Return the story to *Work in progress* status
        
        b. Review the log of the unsuccessful Pipelines run via the *Details* link that will appear in the **Checks** section of the GitHub PR page. You can expand the various sections of the log and review to find the issue that needs to be addressed. Consult with other DigEx members on next steps whenever needed.

    - If Pipelines ran successfully:

        - Move your story to *Ready for testing* status.
        
        - Observe the Acquia Cloud Platform application dashboard and find the new CD (testing) environment that corresponds to your new PR.
        
            CD environments are a bit different than standard environments local / dev / stage / prod, but appear in the same dashboard. In the dashboard, the CD environment ***title*** will be *pipelines-build-pr-**x***, where **x** is equal to the GitHub pull request number (*not* the story ID or commit ID).
    
            This is a ***different*** number than the "ODE" (On-Demand Environment) ID number that appears **in the CD environment URL**. (For example, a CD environment titled *pipelines-build-pr-41* might be accessed via URL *https[]()://wcor****ode24****.prod.acquia-sites.com*.)
    
            **Make a comment on the GitHub PR page noting the ODE ID number.** For example, "QA can begin on ODE42." Avoid placing the actual CD environment URL in the **public** GitHub PR page. The QA reviewer can determine the URL based on the ID number.
        
        - QA can begin. If a DigEx team member doesn't pick up your item for QA within 24 hours, @-notify DigEx Team via the PR thread in the GitHub Teams channel and request QA. The process from the perspective of the QA reviewer is detailed in the [*QA process*](#qa-process) section.

5. Once someone has signed off on QA, the Build Coordinator will attempt to **merge** the PR. Our workflow designates the Build Coordinator to merge the pull request. Squash-and-merge will be the standard merge method.

    (**Note:** Prior to merge, you may receive a message from the Build Coordinator that your PR is "approved but stale". You will be asked to visit your PR page, and in the ***Merge*** section of the PR dashboard, click **Update branch**. GitHub should attempt to automatically merge the changed upstream code with your story/feature branch. If there is a merge conflict, GitHub will guide you in the process of resolving the conflict by editing the conflicted file(s).)

	Once the PR has been merged:

	- The CD environment will disappear.

	- Build Coordinator will move the item to the *Complete* column of the tracking board.

	- GitHub will offer to delete the merged story branch from your forked repo---this is almost always a good idea, since you won't be needing this branch after the merge.

	- You should also delete the story branch from your local IDE---go back to your IDE and ```git checkout develop && git branch -d [merged-story-branch-name]``` to tidy up.

6. Acquia Pipelines will run *again*---this time, on the primary Dev site build. As before, if no issues occur, the Pipelines test will pass. This will result in an automatic push of the code to the ***Acquia*** git repository for the Dev site (*pipelines-build-develop*) and code will automatically deploy to the primary Dev site.

## QA workflow

After a PR is created, and Pipelines has run successfully according to the ***Checks*** section of the PR dashboard (at the bottom of the PR page), the story can be placed in *Ready for testing* status.

A DigEx team member should volunteer to pick up the item for QA, preferably within 24 hours of PR creation. The story item should be tested fully according to the Test Plan included in the story's acceptance criteria.

**QA is not optional** except in rare cases.

**You can not perform QA on your own story/feature.**

Our current QA mode of practice is "round robin". In round robin QA, all DigEx members should pick up a QA item from *Ready for testing* before beginning a new story (unless there are 3 features already in *Testing* status).

(Any DigEx Team member not currently working on a story can begin QA for a story at any time if they are available.)

If you decide to accept an item for QA, **please be prepared to complete QA within 24 hours**.

Items in the *Testing* column should **all** be in some form of active QA. 

Active QA is marked by the presence of a QA-specifc ***Reviewer*** in the GitHub PR page. 

While we await additional CD environments, our current limit is 3, so no more than 3 items will be in the *Testing* column of the sprint board at one time. (Some exceptions will occur, e.g. a document in review may be seen in *Testing* but wouldn't have a CD environment.)

If there are already at least 3 **code-related** stories in *Testing*, **QA is saturated and sprint progress will be blocked** until there are less than 3 **code-related** items in *Testing*.

### QA process

1. Drag the item you will be testing from the *Ready for testing* column to *Testing*.

2. Assign yourself as a QA-specific ***Reviewer*** on the GitHub PR page.

3. Make note of the **ODE** (On-Demand Environment) ID number, which should have been noted in a comment on the GitHub PR page. 

    (If it wasn't, you can review [open Pull Requests](https://github.com/Washington-County/COUNTY-DRUPAL/pulls) to match the PR for your QA story item to the CD environment in the Acquia Cloud Platform application dashboard, and retrieve the ODE ID/URL.
    
4. Login to the CD environment site. The simplest way to do this is to retrieve a one-time login remotely from the CD environment. You can use the following command to get the one-time login URL, using the ODE ID number:

    ``` acli remote:drush @wcor.ode24 uli ```

    :warning: **Note:** The result will be a URL that begins with *https[]()://default/...* -- **you will have to replace "default" with the CD environment domain**. It will be *wcorode****XX****.prod.acquia-sites.com*, where **XX** is the ODE ID number.

5. Once you've accessed the CD environment site as admin, ensure the test plan can be replicated exactly. Note that the CD environment is separate from the main Dev site and all local IDEs. (If you break something in the site, the CD environment can be easily recreated -- contact a WSA if you need assistance.)

6. If any condition of the test plan is ***not*** satisfied:

    - In the ***Review*** pane of the GitHub PR dashboard, make a comment regarding what part of the test plan failed, and @-notify the developer.
    
        Select *Request changes* below the review comment field and **Submit**.
    
    - Move the item to the *Work in progress* column of the sprint tracking board.
    
    If *all* conditions of the test plan are satisfied:
    
    - In the ***Review*** pane of the GitHub PR dashboard, add any comments you have, and @-notify both the developer and Build Coordinator. (Comments should include any quality improvement suggestions you have for the developer, regardless of passing the item.) 
    
    - The developer's feature/story deployment resumes with Step 4 of the section [*Completing and deploying your story item*](#completing-and-deploying-your-story-item) describing final cleanup and closeout procedure.

## References

[Ultimate Guide to Agile Git Branching Workflows in Drupal \| Evolving Web Blog](https://evolvingweb.ca/blog/ultimate-guide-agile-git-branching-workflows-drupal) (Method 3)

[A successful Git branching model](https://nvie.com/posts/a-successful-git-branching-model/)
