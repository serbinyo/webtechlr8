<?php

/**
 * @author Serba
 */
class SerbinController {

    public function Action() {
        include VIEWS . "/index.php";
    }

    public function indexAction() {
        include VIEWS . "/index.php";
    }

    public function aboutAction() {
        include VIEWS . "/about.php";
    }

    public function interestsAction() {
        include VIEWS . "/interests.php";
    }

    public function badAction() {
        include VIEWS . "/index.php";
    }

    public function photoAction() {
        include VIEWS . "/photo.php";
    }

    public function contactAction() {
        include VIEWS . "/contact.php";
    }

    public function historyAction() {
        include ADMIN . "/history.php";
    }

    public function studyAction() {
        include VIEWS . "/study.php";
    }

    public function testpageAction() {
        include VIEWS . "/testpage.php";
    }

    public function actionFormAction() {
        include APP . "/models/actionForm.php";
    }

    public function actionTestFormAction() {
        include APP . "/models/actionTestForm.php";
    }

    public function myblogAction() {
        include VIEWS . "/myblog.php";
    }

    public function blogeditorAction() {
        include ADMIN . "/blogeditor.php";
    }

    public function blogupdateAction() {
        include ADMIN . "/blogupdate.php";
    }

    public function guestbookAction() {
        include VIEWS . "/guestbook.php";
    }

    public function guestbookloadfileAction() {
        include ADMIN . "/guestbookloadfile.php";
    }

    public function blogloadfileAction() {
        include ADMIN . "/blogloadfile.php";
    }

    public function registrationAction() {
        include VIEWS . "/registration.php";
    }

    public function statisticsAction() {
        include ADMIN . "/statistics.php";
    }

    public function adminAction() {
        include ADMIN . "/index.php";
    }

    public function adminmenuAction() {
        include ADMIN . "/menu.php";
    }

    public function contentAction() {
        include ADMIN . "/content.php";
    }
    
    public function logincheckAction() {
        include CORE . "/logincheck.php";
    }
    
    public function addcommentAction() {
        include CORE . "/addcomment.php";
    }
}
