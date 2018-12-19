<?php
namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{
    public function add(Comment $comment)
    {
        $q = $this->dao->prepare('INSERT INTO comments SET news = :news, auteur = :auteur, contenu = :contenu, date = NOW()');

        $q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
        $q->bindValue(':auteur', $comment->auteur());
        $q->bindValue(':contenu', $comment->contenu());

        $q->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM comments WHERE id = ' . (int) $id);
    }

    public function deleteFromNews($news)
    {
        $this->dao->exec('DELETE FROM comments WHERE news = ' . (int) $news);
    }

    public function getListOf($news)
    {
        if (!ctype_digit($news)) {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
        }

        $q = $this->dao->prepare('SELECT id, news, auteur, contenu, date FROM comments WHERE news = :news ORDER BY id DESC');
        $q->bindValue(':news', $news, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $comments = $q->fetchAll();

        foreach ($comments as $comment) {
            $comment->setDate(new \DateTime($comment->date()));
        }

        return $comments;
    }

    protected function modify(Comment $comment)
    {
        $q = $this->dao->prepare('UPDATE comments SET auteur = :auteur, contenu = :contenu WHERE id = :id');

        $q->bindValue(':auteur', $comment->auteur());
        $q->bindValue(':contenu', $comment->contenu());
        $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);

        $q->execute();
    }

    public function get($id)
    {
        $q = $this->dao->prepare('SELECT id, news, auteur, contenu, report FROM comments WHERE id = :id');
        $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        if ($comment = $q->fetch()) {
            return $comment;
        }

        return null;
    }

    public function report($id)
    {
        $this->dao->exec('UPDATE `comments` SET report = true WHERE id = ' . (int) $id);
    }

    public function countReport()
    {
        return $this->dao->query('SELECT COUNT(*) FROM comments WHERE report = 1')->fetchColumn();
    }

    public function countComments()
    {
        return $this->dao->query('SELECT COUNT(*) FROM comments')->fetchColumn();
    }

    public function getListCommentsReport($debut = -1, $limite = -1)
    {
        $sql = 'SELECT news.titre titre_news, comments.id, comments.auteur, comments.contenu, comments.news, comments.date
        FROM comments
        INNER JOIN news
        ON comments.news = news.id
        WHERE report = 1
        ORDER BY id DESC';

        if ($debut != -1 || $limite != -1) {
            $sql .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
        }

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $listeCommentsReport = $requete->fetchAll();

        foreach ($listeCommentsReport as $comment) {
            $comment->setDate(new \DateTime($comment->date()));
        }

        $requete->closeCursor();

        return $listeCommentsReport;
    }

    public function valid($id)
    {
        $this->dao->exec('UPDATE `comments` SET `report`= 0 WHERE id = ' . (int) $id);
    }

    public function getListAllComments($debut = -1, $limite = -1)
    {
        $sql = 'SELECT news.titre titre_news, comments.id, comments.auteur, comments.contenu, comments.news, comments.date
        FROM comments
        INNER JOIN news
        ON comments.news = news.id
        ORDER BY id DESC';

        if ($debut != -1 || $limite != -1) {
            $sql .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
        }

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $listeComments = $requete->fetchAll();

        foreach ($listeComments as $comment) {
            $comment->setDate(new \DateTime($comment->date()));
        }

        $requete->closeCursor();

        return $listeComments;
    }

    public function getlastComment()
    {
        $sql = 'SELECT * FROM comments ORDER BY ID DESC LIMIT 1';
        $requete = $this->dao->query($sql);

        $commentData = $requete->fetchAll();
        $data['result'] = $commentData;

        return json_encode($data);

    }

}
