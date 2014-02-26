GIT Workflow
============

This document describes the workflow that we use.

**Table of contents:**

* [New projects](#new-projects)
* [New feature/issue](#new-featureissue)
  * [Update your fork](#update-your-fork)
  * [Create new branch](#create-new-branch)
  * [Submit your work as a pull-request](#submit-your-work-as-a-pull-request)
* [Extra information](#extra-information)
  * [Working on your patch](#working-on-your-patch)
  * [Rebasing a pull request](#rebasing-a-pull-request)
  * [Squashing commits](#squashing-commits)
* [Hub](#hub)
  * [Attaching commits to an existing issue](#attaching-commits-to-an-existing-issue)
* [Relevant Resources](#relevant-resources)


## New projects

Every work you do is done in your own fork of the project you are working on.

1. Fork repository via Github.com
2. Clone your fork: `git clone git@github.com:<username>/project.git`
3. Add upstream remote: `git remote add upstream git@github.com:financial-media/project.git`

Verify this using `git remote -v`, it should look like this:

```
origin	git@github.com:<username>/<project>.git (fetch)
origin	git@github.com:<username>/<project>.git (push)
upstream	git@github.com:financial-media/<project> (fetch)
upstream	git@github.com:financial-media/<project> (push)
```


## New feature/issue

### Update your fork

When starting to work on a new feature/issue, you need to update your fork to reflect the latest version of the upstream:

```
git fetch --all                  # fetches the latest changes from the remote repositories
git checkout master              # selects the master branch 
git reset --hard upstream/master # resets your branch to be exactly the same as the upstream
```

### Create new branch

Now you can create a new branch off of your fork's master branch. It's common practice to name your branches after the feature or issue you're working on. Prefix the branch with `feature-` or `issue-123-` (where 123 is the issue number). For this example though we use `mybranch` for brevity:

```
git checkout -b mybranch
```


To visualize, your setup now looks like this:

```
  Project                 Your GH fork
+----------+            +--------------+
|          |    fork    |              |
| Upstream |  ------->  |    Origin    |
|          |            |              |
| [master] |            |   [master]   |
+----------+            +--------------+
     ^                         ^
     |                         |
     | upstream         origin |
     |                         |
     |                         |
     |       Working dir       |
     |     +-------------+     |
     |     |             |     |
     |     |    Local    |     |
     +---- |             | ----+
           |   [master]  |
           |  [mybranch] |
           +-------------+
```  

Now you can work on the issue/feature.


### Submit your work as a pull-request

When you are done with the issue or feature, first make sure all the unit tests work. Then proceed with the following steps:

1. Commit all outstanding changes (don't forget to add new files and remove deleted files, use a [GUI](http://mac.github.com) if you are unsure about this!):

  ```
  git add --all . # adds, modifies, and removes index entries to match the working tree 
  git commit      # record changes to the repository
  ```

2. Make sure your branch does not have any conflicts with upstream. Perform a rebase to do this (see [rebasing](#rebasing-a-pull-request)):

  ```
  git fetch upstream         # fetch latest changes from upstream
  git rebase upstream/master # resets your branch and applies your changes on top of it
  ```

3. Squash commits if necessary (see [Squashing commits](#squashing-commits))

4. Now you're ready to submit your patch: `git push origin mybranch`. Go to the repository on `https://github.com/<username>/<project>`. You will see a yellow alert-bar with the name of your branch and a button to view it and/or create a PR from it. Click the button, you will be taken to a page where you can confirm the title and description of the PR. When done, click the confirmation button to create the actual PR.

Done! Your PR will be reviewed by a colleague.
 
 
## Extra information

### Working on your patch
Basically follow the [Symfony guidelines](http://symfony.com/doc/current/contributing/code/patches.html#work-on-your-patch) for this:

> Work on the code as much as you want and commit as much as you want; but keep in mind the following:
>
> * Read about the Symfony [conventions](http://symfony.com/doc/current/contributing/code/conventions.html) and follow the [coding standards](http://symfony.com/doc/current/contributing/code/standards.html) (use git diff --check to check for trailing spaces -- also read the tip below);
> * Add unit tests to prove that the bug is fixed or that the new feature actually works;
> * Try hard to not break backward compatibility (if you must do so, try to provide a compatibility layer to support the old way) -- patches that break backward compatibility have less chance to be merged;
> Do atomic and logically separate commits (use the power of git rebase to have a clean and logical history);
> Squash irrelevant commits that are just about fixing coding standards or fixing typos in your own code;
> Never fix coding standards in some existing code as it makes the code review more difficult;
> Write good commit messages (see the tip below).

### Rebasing a pull request

Sometimes during the time you've been working on an issue, other changes have been merged into the project. This can lead to conflicts when submitting a pull request. To avoid this you can rebase your branch against upstream, which basically means: start over with the latest version, and re-apply my changes to that.

It is good practice to always rebase before submitting a pull request, however an existing pull request may have to be rebased after upstream has been updated. If this happens you will be asked to rebase, unfortunately you cannot see this yourself.

1. `git checkout mybranch`
2. `git fetch upstream`
3. `git rebase upstream/master`
4. Sometimes files cannot be automatically merged, the rebase command will tell you about these files. Fix these files and add them back to the index with: `git add the-file-that-you-fixed`.
5. When all conflicted files are added you can continue the rebasing with `git rebase --continue`.
5. `git push origin mybranch` (use `--force` if your branch is already pushed to remote, note that this rewrites history)

**About using the force:**

> When doing a `push --force`, always specify the branch name explicitly to avoid messing other branches in the repo (`--force` tells Git that you really want to mess with things so do it carefully).
>
> http://symfony.com/doc/current/contributing/code/patches.html#rework-your-patch


### Squashing commits

Squashing commits means converting multiple commits into one commit. This is done to prevent meaningless commits (code style fixes, typo fixes, 'wip', etc). Sometimes you will be asked to squash your commits. But you are encouraged to check this yourself before submitting a pull request. Keep in mind that every commit will be merged, and we like a readable log, without dozens of 'CS fix' commits.

You can squash commits using an interactive rebase:

```
git checkout mybranch
git fetch --all
git rebase -i upstream/master
```

This will open your default editor (probably vim). In the editor, mark your initial commit with `pick`, and all commits that have no real meaning with `squash`. Save your changes and you will be prompted with another editor-screen. This time you'll see all the squashed commits merged into the first commit that was picked before it. It's nice to still see what commits were actually squashed so you can often leave this screen unchanged.

When you're done you can push your changes:

```
git push origin mybranch --force
```

See [this tutorial](http://phuu.net/2014/02/24/rebase-you-interactively-for-great-good.html) for an extensive example.

**NOTE:** You can also use PHPStorm to do the interactive rebase, offering some nicer GUI options for changing the messages etc. Check out the documentation for it [here](https://www.jetbrains.com/phpstorm/webhelp/rebasing-commits-dialog.html).


## Hub

It's recommended to use [Hub](http://hub.github.com): Github's tool that adds some flavour and commands to the git command line interface. You can read their documentation, but we'll give one example here that we use:

### Attaching commits to an existing issue

When working on an issue, you can attach your commits to that issue instead of creating a separate pull request. Although this specific feature is marked as deprecated, we still use it until Github recommends a different approach as good practice.

To create a pull request of your current branch, perform the following steps:

1. Make sure you have already pushed your branch (don't create a PR yet, though!)
2. Run the following command: `hub pull-request -i 123` where `123` is the issue number.
3. If all is well you will get a simple confirmation message containing the URL to the created PR.
4. You can continue working on your PR in the meantime; any additional pushed commits will be added to the PR.


## Relevant resources

* [GitHub pull request documentation](https://help.github.com/articles/using-pull-requests)
* [Hub](http://hub.github.com)
* [Git merge vs. rebase](http://mislav.uniqpath.com/2013/02/merge-vs-rebase/)
* [Rebase you interactively for great good](http://phuu.net/2014/02/24/rebase-you-interactively-for-great-good.html)
