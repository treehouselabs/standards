GIT Workflow
============

## Creating a branch

Working on a new feature for a project? Start by creating a feature-branch first (start your branch name with ``feature-``).

Working on an issue for a project? Start by creating an issue-branch (start your branch name with ``issue-123``, where 123 is the number of the issue). Jump straight to the [Hub documentation](#hub) to make your life easier!

## Pull requests

When work is done, you send a Pull Request. Your PR will then be reviewed by your colleagues and merged.
We have described the process of committing and PR-ing below, but to learn more about creating pull-requests, read the [GitHub pull request documentation](https://help.github.com/articles/using-pull-requests).

Basicallly, here's how a it goes:

1. Someone creates an issue, or you have a great idea for a new feature
2. First, make sure your local master is updated to prevent already starting on the wrong foot (being forced to rebase)

        git checkout master
        git pull

2. You create a new branch on your local repository:

        git checkout -b my-branch

3. You make the necessary fixes to solve the issue, using one or more commits in the new branch

        git commit -m "fixed ..."
        ...
        git commit -m "replaced ..."

3. You push this branch back to the origin:

        git push origin my-branch

4. Go to the repository on http://github.com/financial-media/name-of-the-repository-here
5. You will see a yellow alert-bar with the name of your branch and a button to view it and/or create a PR from it. Click the button.
6. You will be taken to a page where you can confirm the title and description of the PR. When done, click the confirmation button to create the actual PR.

### <a name="hub"></a>Solving an issue? Use Hub!

Often you may just be solving an issue that has already been created by someone on the GitHub repository.

Now, instead of creating a separate PR for the issue, and then referring to this issue from within your PR, you can make this all a lot easier using a neat tool called [Hub](https://github.com/github/hub).

Specifically, it's ``pull-request -i [id-of-the-issue-here]`` command which basically converts a given issue into a PR using the branch you have checked out.
Although this specific feature is marked as deprecated, there is no reason you can't use it for the time being. So here's how it works:

1. Make sure you have already pushed your branch at least once to the origin (don't create a PR yet, though!)
2. Using the Terminal, navigate to the directory where you have checked out your branch.
3. Run the following command: ``hub pull-request -i 123``
4. You will get a warning the command is deprecated, which you can ignore for now.
5. If all is well you will get a simple confirmation message containing the URL to the created PR.
6. Go ahead and browse to the given URL, the entire issue (with all it's comments) has been converted into a PR! You will get excited now...
7. You can continue working on your PR in the meantime; any additional changes will be shown on this very page, and others can see what is happening without having to know whether someone already created a PR for their issue.

## Rebase

If you are asked to 'rebase' your PR:

1. Make sure you have your branch checked out `git checkout my-branch`
2. Then update with `git fetch`
3. Now rebase with `git rebase origin/master`
4. When you get a conflict you have to fix it and add the file(s) back to the index with: `git add the-file-with-conflict-that-you-fixed.php`.
5. When all conflicted files are added you can continue the rebasing with `git rebase --continue`.
6. When all is set you can push to origin with: `git push origin my-branch -f`

## Squashing commits

1. If you are asked to 'squash your commits', do the following (note the `-i` option):

        git checkout my-branch
        git fetch origin
        git rebase -i origin/master

2. When prompted, mark your initial commit with *pick*, and all commits that have no real meaning with *squash*. If you are viewing this rebase in VIM (the default when using the command-line), you can then type ``:wq`` to get out of the editor and continue the rebase.
3. You will be prompted with another editor-screen, this time you see all the squashed commits' messages merged into the first commit that was picked before it. It's nice to still see what commits were actually squashed so you can often leave this screen unchanged.
4. Finally, push your changes via:

        git push --force origin my-feature-branch

**NOTE:** You can also use PHPStorm to do the interactive rebase, offering some nicer GUI options for changing the messages etc. Check out the documentation for it [here](https://www.jetbrains.com/phpstorm/webhelp/rebasing-commits-dialog.html)

## Relevant Resources

* [Hub](https://github.com/github/hub)
* [Git merge vs. rebase](http://mislav.uniqpath.com/2013/02/merge-vs-rebase/)
