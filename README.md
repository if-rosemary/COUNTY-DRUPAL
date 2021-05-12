Washington County, OR - Site Redesign Project
====

Drupal 9 site redesign project for Washington County, Oregon.

Hosted on Acquia Cloud Platform.
Developed on Acquia Cloud IDE.

<details><summary><h2>First-time setup</h2></summary><p>

1. Create your Acquia Cloud IDE. This will be covered in a separate document (linked here soon).

2. Fork the *Washington-County / COUNTY-DRUPAL* repository (repo) to your own GitHub account.

	Login to your GitHub account, visit the [primary repo GitHub page](https://github.com/Washington-County/COUNTY-DRUPAL) and click the ***Fork*** button. (This will later be referred to as the **upstream** repository.)

3. Open your Acquia Cloud IDE. **Be sure** to click the **Configure IDE** button displayed to setup your initial SSH keys to connect you to Cloud Platform. (We've had mixed success doing this manually from terminal.)

	Visit the [API Tokens](https://cloud.acquia.com/a/profile/tokens) page and create a token named "Acquia Cloud IDE". Leave this window open.

	When prompted, copy and paste the API key and secret from your browser to the terminal within Cloud IDE. A confirmation will appear that credentials were saved.

4. For a new Cloud IDE instance, you will need to create an SSH key that can be used to access Acquia Cloud Platform and GitHub.  Click either link to expand instructions.

	<details><summary>Acquia Cloud Platform</summary><p>

	a. Enter this command in Cloud IDE Terminal:

		ssh-keygen -b 4096 -C [your_email]@co.washington.or.us

	b. You'll be prompted to *Enter the file in which to save the key (/home/ide/.ssh/id_rsa):* -- enter the following full path with adjusted filename:

		/home/ide/.ssh/id_rsa_acp

	c. You'll be prompted to enter a passphrase. You can simply **press Enter** to bypass this.

	d. Enter the following command:

		ls ~/.ssh

	You should see the presence of files "id_rsa_acp" and
"id_rsa_acp.pub".

	e. Now enter:

		cat ~/.ssh/id_rsa_acp.pub

	All the text that appears (starting with "ssh" and ending with your e-mail address) should be highlighted and copied to the clipboard (Ctrl+C). **Be sure not to highlight any additional characters or spaces before copying.**

	f. Open your individual Acquia Cloud Platform [SSH
Keys](https://cloud.acquia.com/a/profile/ssh-keys) page. Click the **Add SSH Key** button. Give the new key a title (e.g. "Your Name - Acquia Cloud IDE"), then paste the public key text into the Public Key field and save. The new key should appear in your list of keys.</p></details>

	<details><summary>GitHub</summary><p>

	a. Make sure you've already created a GitHub account, and then use whichever email account is assigned to your established GitHub account. Start by entering this command in Cloud IDE Terminal:

		ssh-keygen -t ed25519 -C "[your_email]@co.washington.or.us"

	b. You'll be prompted to *Enter the file in which to save the
key (/home/ide/.ssh/id_ed25519):* -- just **press Enter** to accept the default.

	  c. You'll be prompted to enter a passphrase. You can simply **press Enter** to bypass this.

	d. Enter the following command:

		ls ~/.ssh\

	You should see the presence of files "id_ed25519" and "id_ed25519.pub".

	e. Now enter:

		cat ~/.ssh/id_ed25519.pub

	All the text that appears (starting with "ssh" and ending with your e-mail address) should be highlighted and copied to the clipboard (Ctrl+C). **Be sure not to highlight any additional characters or spaces before copying.**

	f. Go back to [GitHub Keys](https://github.com/settings/keys) page. Click the **New SSH key** button. Give the new key a title like "Acquia Cloud IDE", then paste the public key text into the body and save. The new key should appear in your list of keys.

	g. Test your SSH-based connection to GitHub with

		ssh -T git@github.com

	(Make sure the switch is a capital "-T".)

	GitHub should respond with a "Hi *[username]*" greeting.</p></details>


5. Initialize your local git repo in your IDE. This will create a hidden folder called ".git" where your local git data will live.

		git init

6. Define your remote repositories. "Origin" will be your forked repository, and "upstream" will be the primary WashCo repository.

		git remote add origin git@github.com:[your-GitHub-username]/COUNTY-DRUPAL.git
		git remote add upstream git@github.com:Washington-County/COUNTY-DRUPAL.git

7. Verify remote repos (origin and upstream) are correctly linked from your local IDE:

		git remote -v

8. Since your prompt should show you've checked out the master branch, let's retrieve the contents of the origin master branch to be current there. (We use this method rather than git clone because it allows you to treat \~/project as your actual project root, simplifying things.)

		git pull

	(You may see a message stating "The authenticity of host 'github.com *(IP)*' can't be established. Are you sure you want to continue connecting?". Answer "yes".)

9. Now, locally checkout develop branch, and then pull the latest code from the develop branch of the primary (upstream) repo:

		git checkout develop
		git pull upstream develop

	(This should be a clean update fast forwarded to the state of your canonical team repository. If you see a merge conflict, stop and figure out why.)

10. Pull the database from the dev environment.

		acli pull:database wcor.dev

  11. Use Composer to install dependencies, and deploy the site.

		```
		composer install
		drush deploy
		blt source:build
		```
</p></details>


## Starting a new story branch

#### Do not do this if you are still working on another feature or story activity.

#### Work one story at a time *to completion*.

  1. To start developing a story item, you will first want to refresh your dev site (unless you literally just finished with "First-time setup").

		Checkout your local develop branch and pull the upstream develop branch down (to ensure you're synced with other completed features/story activities):
		```
		git checkout develop
		git pull upstream develop
		```

		(A nano editing session may appear for you to enter a merge commit message -- you can just press **Ctrl+X** to exit nano, and the default message will be entered.)

2. Be sure to grab the dev database, refresh the composer build, and re-deploy the site via drush:

		acli pull:database wcor.dev
		composer install
		drush deploy

3. Now, checkout your new story branch. The branch name convention is ***activity/story-id***. Possible activities include:

	- feature (actual functionality development)
	- hotfix (short-fuse correction of an issue)
	- bugfix (fix a bug)
	- spike (experimentation in support of research)

	Enter the following:
	```
	git checkout -b feature/[story-id]
	```
	(story ID in the format: STRY0012345)

4. You will probably need to login as admin at some point to your local dev site. Use ```drush uli``` to get a one-time login link, and Ctrl+click the link.

	(If this results in a "Temporarily Unavailable" error from accounts.acquia.com, try signing into cloud.acquia.com again in your browser before using the link.)

5. Work on the story item. Jump down to the ***Daily workflow*** section for specific daily actions.

	**IMPORTANT**: Remember the difference between content and configuration data as you work. For example, if you create a taxonomy, any terms you add to your local dev site will not propagate to the general dev site or beyond.

	***Types*** of things (e.g. a taxonomy, content type, user *role*, etc) are configuration, and are thought of as code thanks to ```drush cex```.

	Code only moves *upstream* and content (DB & files) only moves *downstream* through environments. Any content you create in local dev (for example, to test a feature) will not be conveyed past local dev.

6. Once development is complete, follow the instructions in ***Completing and deploying your story item***.

## Daily workflow

1. At the start of any given day doing development work:

	a. Your terminal prompt should indicate that you're still working on the most recent branch, presumed to be **your story branch**. If it doesn't, do the following.

		git checkout [story-branch-name]

	b. Pull (and merge) code from the primary (upstream) repo's develop branch, so that you can remain current with the accepted dev codebase. Doing this often will minimize frustration and problems later.

		git pull upstream develop

	c. Refresh database from the development environment.

		acli pull:database wcor.dev
		composer install

	d. Re-deploy the site with drush so that all the data you've refreshed is active on the site. (This incorporates a config import, resulting database updates, cache clear, and deploy hook.)

		drush deploy

2. Make changes to your local dev site.

3. Stage those changes for the next commit to your local story branch on Cloud IDE, and then commit them. (This can be done multiple times a day, or just once at the end.)

	a. First, you must export configuration items living in the database to YAML code files. (Answer "yes" when prompted to delete and replace existing config export files.)

		drush cex

	b. Do a git status check:

		git status

	Observe the files in red -- these are new or modified files that have not yet been ```git add```-ed to the upcoming commit to your story branch.\

	Determine which of these files should be added to your story branch. (Not all files will need to be tracked with the story branch changes -- in some cases, you will want to skip tracking of certain files.)

	c. Add any untracked files relevant to your story branch that will become part of the next commit.

		git add .

	The period ```.``` indicates that all files below the current folder (your prompt should display ```~/project```) will be included.

	d. Commit the changes you've staged to your local Cloud IDE story branch. Use "WCOR-" and the story ID number at the start of your commit message (e.g. WCOR-0012345). Write your commit message in present tense starting with an action verb to describe the latest round of changes. Example:

		git commit -m "WCOR-[story-ID-number]: Add content type Page."

	e. When you first push your branch to your origin (forked repo) develop branch:
	```
	git push -u origin [story-branch-name]
	```
	(The -u option would allow you to simply use ```git push``` on your next push, without specifying that you're pushing your story branch to origin.)


## Completing and deploying your story item

1. When the feature or story item is considered complete, create and submit a pull request (PR).

	a. To ensure you are working against the up-to-date dev codebase from the primary/canonical (upstream) develop branch, pull the latest changes.

		git pull upstream develop

	b. Test your feature / story item locally once more after the merge to ensure it works as intended.

	c. Export config items in database to YAML files in code:

		drush cex

	d. Push your story branch to your origin (forked) repo:

		git push --u origin [story-branch-name]

	(or just git push if you previously did git push --u)

	e. In a browser, open the PR for the merge of the new branch into primary/canonical (upstream) develop branch. You'll see an alert about it at the top of your forked repo GitHub page:

		https://github.com/[your-GitHub-username]/COUNTY-DRUPAL

	Click the **Compare & pull request** button. Be sure to add one or more reviewers, confirm the PR title, and enter a comment if desired. Then click **Create pull request**.

	f. The PR page will load. Scrolling down, you will see the status of the PR:

	- **Review** will tell you whether the PR has been reviewed and approved.

	- **Checks** will tell you whether Cloud Platform Pipelines has successfully tested the new branch.

	- **Merge** will tell you whether the new branch was merged with the primary (upstream) develop branch.

2. Acquia Pipelines will run against the submitted PR. This includes a number of automated technical checks along with any Behat tests that have been written. If no issues occur, the Pipelines test will pass. (If not, a details link will appear, allowing you to review where the test failed in Acquia Pipelines.)

	If Pipelines ran successfully:

	- Reviewers should be notified via email that a pull request is waiting for approval ("review"). A minimum of one approving review is required. An approving review may or may not include comments, and will enable the Merge pull request button.

	- Acquia Cloud Platform will automatically open a CD (Continuous Delivery) environment for the purpose of QA work and signoff.  CD environments are a bit different than standard environments local / dev / stage / prod, but appear in the same list. The codebase specified when the CD environment is opened should be pipelines-build-pr-***x***, where **x** is equal to the GitHub pull request number (*not* the story ID or commit ID).

3. If at least one reviewer adds their approving review to the PR, and our QA Lead has signed off on the site build they have tested in the CD environment, then the PR will be merged. Our workflow designates the Build Coordinator to merge the pull request. Squash-and-merge will be the standard merge method.

	Once the PR has been merged:

	- The CD environment will disappear.

	- GitHub will offer to delete the merged story branch from your forked repo---you may as well do it since you won't be needing this branch after the merge.

	- You should also delete the story branch from your local IDE---go back to your IDE and ```git checkout develop && git branch -d [merged-story-branch-name]``` to tidy up.

4. Acquia Pipelines will run *again*---this time, on the primary Dev site build. As before, if no issues occur, the Pipelines test will pass. This will result in an automatic push of the code to the ***Acquia*** git repository for the Dev site (*pipelines-build-develop*) and code will automatically deploy to the primary Dev site.

## References

[Ultimate Guide to Agile Git Branching Workflows in Drupal \| Evolving Web
Blog](https://evolvingweb.ca/blog/ultimate-guide-agile-git-branching-workflows-drupal) (Method 3)

[A successful Git branching model](https://nvie.com/posts/a-successful-git-branching-model/)
