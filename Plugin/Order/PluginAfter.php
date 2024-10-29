<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_DeleteOrder
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */

namespace Mavenbird\DeleteOrder\Plugin\Order;

class PluginAfter extends \Mavenbird\DeleteOrder\Plugin\PluginAbstract
{
    /**
     * @var \Magento\Backend\Helper\Data
     */
    protected $data;

    /**
     * PluginAfter constructor.
     * @param \Magento\Authorization\Model\Acl\AclRetriever $aclRetriever
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Backend\Helper\Data $data
     */
    public function __construct(
        \Magento\Authorization\Model\Acl\AclRetriever $aclRetriever,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\Helper\Data $data
    ) {
        parent::__construct($aclRetriever, $authSession);
        $this->data = $data;
    }

    /**
     * After Get Back Url
     *
     * @param \Magento\Sales\Block\Adminhtml\Order\View $subject
     * @param [type] $result
     * @return void
     */
    public function afterGetBackUrl(\Magento\Sales\Block\Adminhtml\Order\View $subject, $result)
    {
        if ($this->isAllowedResources()) {
            $params = $subject->getRequest()->getParams();
            $message = __('Are you sure you want to do this?');
            if ($subject->getRequest()->getFullActionName() == 'sales_order_view') {
                $subject->addButton(
                    'mavenbird-delete',
                    ['label' => __('Delete'), 'onclick' => 'confirmSetLocation(\'' . $message . '\',\'' . $this->getDeleteUrl($params['order_id']) . '\')', 'class' => 'mavenbird-delete'],
                    -1
                );
            }
        }
        return $result;
    }

    /**
     * Delete Url
     *
     * @param [type] $orderId
     * @return void
     */
    public function getDeleteUrl($orderId)
    {
        return $this->data->getUrl(
            'deleteorder/delete/order',
            [
                'order_id' => $orderId
            ]
        );
    }
}
