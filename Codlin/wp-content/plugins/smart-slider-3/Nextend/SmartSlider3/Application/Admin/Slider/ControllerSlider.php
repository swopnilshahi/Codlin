<?php


namespace Nextend\SmartSlider3\Application\Admin\Slider;


use Nextend\Framework\Notification\Notification;
use Nextend\Framework\Request\Request;
use Nextend\SmartSlider3\Application\Admin\AbstractControllerAdmin;
use Nextend\SmartSlider3\Application\Model\ModelSliders;
use Nextend\SmartSlider3\BackupSlider\ExportSlider;

class ControllerSlider extends AbstractControllerAdmin {

    protected $sliderID = 0;

    protected $groupID = 0;

    public function initialize() {
        parent::initialize();

        $this->sliderID = Request::$REQUEST->getInt('sliderid');
        $this->groupID  = Request::$REQUEST->getInt('groupID', 0);
    }

    /**
     * @return int
     */
    public function getSliderID() {
        return $this->sliderID;
    }

    public function actionClearCache() {
        if ($this->validateToken()) {
            $slidersModel = new ModelSliders($this);
            $slider       = $slidersModel->get($this->sliderID);
            if ($this->validateDatabase($slider)) {

                $slidersModel->refreshCache($this->sliderID);
                Notification::success(n2_('Cache cleared.'));

                $groupData = $this->getGroupData($this->sliderID);

                $this->redirect($this->getUrlSliderEdit($this->sliderID, $groupData['group_id']));
            }
        }
    }

    public function actionEdit() {

        if ($this->validatePermission('smartslider_edit')) {

            $slidersModel = new ModelSliders($this);

            $slider = $slidersModel->get($this->sliderID);

            if (!$slider) {
                $this->redirectToSliders();
            }

            if ($slider['type'] == 'group') {

                $this->doAction('editGroup', array(
                    $slider
                ));

            } else {

                $groupData = $this->getGroupData($this->sliderID);

                $view = new ViewSliderEdit($this);
                $view->setGroupData($groupData['group_id'], $groupData['title']);
                $view->setSlider($slider);
                $view->display();

            }
        }
    }

    public function actionTrash() {
        if ($this->validateToken() && $this->validatePermission('smartslider_delete')) {
            $slidersModel = new ModelSliders($this);
            $mode         = $slidersModel->trash($this->sliderID, $this->groupID);
            switch ($mode) {
                case 'trash':
                    Notification::success(n2_('Slider moved to the trash.'));
                    break;
                case 'unlink':
                    Notification::success(n2_('Slider removed from the group.'));
                    break;
            }

            if ($this->groupID > 0) {
                $this->redirect($this->getUrlSliderEdit($this->groupID));
            } else {
                $this->redirectToSliders();
            }
        }
    }

    public function actionDuplicate() {
        if ($this->validateToken() && $this->validatePermission('smartslider_edit')) {
            $slidersModel = new ModelSliders($this);
            if (($sliderid = Request::$REQUEST->getInt('sliderid')) && $slidersModel->get($sliderid)) {
                $newSliderId = $slidersModel->duplicate($sliderid);
                Notification::success(n2_('Slider duplicated.'));

                $groupData = $this->getGroupData($newSliderId);

                $this->redirect($this->getUrlSliderEdit($newSliderId, $groupData['group_id']));
            }
            $this->redirectToSliders();
        }
    }

    public function actionExport() {
        if ($this->validateToken() && $this->validatePermission('smartslider_edit')) {
            $export = new ExportSlider($this, $this->sliderID);
            $export->create();
        }
    
    }

    public function actionExportHTML() {
        if ($this->validateToken() && $this->validatePermission('smartslider_edit')) {
            $export = new ExportSlider($this, $this->sliderID);
            $export->createHTML();
        }
    
    }
}