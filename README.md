# Blog app

Cd public

Then run `php cli.php {command}`

### List of commands:

- `create_user {user_id}` - creates a user with provided id;
- `get_user {user_id}` - get user with provided id;
- `create_post {user_id}` - creates a post from user with provided user id;
- `get_posts {user_id}` - get all posts created by user with provided user id;
- `create_comment {user_id} {post_id}` - creates a comment to a post by user;
- `get_comments {post_id}` - get all comments for a specific post;