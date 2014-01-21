GIT Workflow
============

## Rebase

To rebase follow these instructions:

1. Make sure you have your feature branch checked out `git checkout my-feature-branch`
2. Then update with `git fetch`
3. Now rebase with `git rebase origin/master`

When you get a conflict you have to fix it and add the file(s) back to the index with: `git add the-file-with-conflict-that-you-fixed.php`. When all conflicted files are added you continue with `git rebase --continue`.

When all is set you can push to origin with: 

`git push origin my-feature-branch -f`
