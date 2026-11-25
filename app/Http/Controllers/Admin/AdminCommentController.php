<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Http\Controllers\Controller;

class AdminCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.comment.index', [
            'comments' => Comment::with('post')->latest()->paginate(20),
        ]);
    }

    /**
     * Approve the specified comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function approve(Comment $comment)
    {
        $comment->update(['approved' => true]);

        return redirect('/admin/comment')->with('success', 'Komentar Berhasil Disetujui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect('/admin/comment')->with('success', 'Komentar Berhasil Dihapus');
    }
}
