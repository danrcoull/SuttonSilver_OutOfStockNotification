<?php


namespace SuttonSilver\OutOfStockNotification\Controller\Adminhtml\Notifications;

class Delete extends \SuttonSilver\OutOfStockNotification\Controller\Adminhtml\Notifications
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('notifications_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('SuttonSilver\OutOfStockNotification\Model\Notifications');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Notifications.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['notifications_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Notifications to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
