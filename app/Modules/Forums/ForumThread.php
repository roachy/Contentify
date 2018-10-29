<?php namespace App\Modules\Forums;

use App\Modules\Forums\ForumPost;
use DB, SoftDeletingTrait, BaseModel;

class ForumThread extends BaseModel {

    use SoftDeletingTrait;

    protected $slugable = true;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'sticky', 'closed', 'forum_id'];

    protected $rules = [
        'title'     => 'required|min:3',
        'sticky'    => 'sometimes|boolean',
        'closed'    => 'sometimes|boolean',
        'forum_id'  => 'integer',
    ];

    public static $relationsData = [
        'creator'   => [self::BELONGS_TO, 'User', 'title' => 'username'],
        'forum'     => [self::BELONGS_TO, 'App\Modules\Forums\Forum'],
        'posts'     => [self::HAS_MANY, 'App\Modules\Forums\ForumPost', 'dependency' => true],
    ];

    /**
     * Refreshes the thread's meta infos
     * 
     * @return void
     */
    public function refresh()
    {
        $forumPost  = ForumPost::whereThreadId($this->id)->orderBy('created_at', 'desc')->firstOrFail();
        $postsCount = ForumPost::whereThreadId($this->id)->count();

        $this->posts_count  = $postsCount;
        $this->updated_at   = $forumPost->updated_at;
        $this->forceSave();
    }

    /**
     * Select only those forum threads the user has access to.
     * WARNING: Creates a JOIN with the forum_threads table.
     *
     * @param Builder   $query  The Eloquent Builder object
     * @param User      $user   User model or null if it's the current client
     * @return Builder
     */
    public function scopeIsAccessible($query, $user = null)
    {
        $query->select('forum_threads.*')
            ->join('forums', 'forum_threads.forum_id', '=', 'forums.id');

        if (! $user) {
            $user = user();
        }

        if ($user) {
            $internal = $user->hasAccess('internal');

            $teamIds = DB::table('team_user')->whereUserId($user->id)->lists('team_id');
            $teamIds[] = -1; // Add -1 as team ID so the SQL statements (`team_id` in (...)) always has valid syntax

            return $query->where('internal', '<=', $internal)->where(function($query) use ($teamIds)
            {
                $query->whereNull('team_id')
                      ->orWhereIn('team_id', $teamIds);
            });
        } else {
            return $query->whereInternal(0)->whereNull('team_id');
        }  
    }

}