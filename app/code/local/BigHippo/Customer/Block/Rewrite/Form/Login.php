<?php
/**
 * Created by PhpStorm.
 * User: ignaciopascual
 * Date: 4/20/16
 * Time: 7:28 AM
 */

class BigHippo_Customer_Block_Rewrite_Form_Login extends Mage_Customer_Block_Form_Login
{

    protected function _prepareLayout()
    {
    }

    public function getWelcome()
    {
        if (empty($this->_data['welcome'])) {
            if (Mage::isInstalled() && Mage::getSingleton('customer/session')->isLoggedIn()) {
                $this->_data['welcome'] = $this->__('Welcome, %s!', $this->escapeHtml(Mage::getSingleton('customer/session')->getCustomer()->getName()));
            } else {
                $this->_data['welcome'] = Mage::getStoreConfig('design/header/welcome');
            }
        }

        return $this->_data['welcome'];
    }

    /**
     * Deserialize renders from string
     *
     * @param string $renders
     * @return Mage_Checkout_Block_Cart_Sidebar
     */
    public function deserializeRenders($renders)
    {
        if (!is_string($renders)) {
            return $this;
        }

        $renders = explode('|', $renders);
        while (!empty($renders)) {
            $template = array_pop($renders);
            $block = array_pop($renders);
            $type = array_pop($renders);
            if (!$template || !$block || !$type) {
                continue;
            }
            $this->addItemRender($type, $block, $template);
        }

        return $this;
    }

    /**
     * Add renderer for item product type
     *
     * @param   string $productType
     * @param   string $blockType
     * @param   string $template
     * @return  Mage_Checkout_Block_Cart_Abstract
     */
    public function addItemRender($productType, $blockType, $template)
    {
        $this->_itemRenders[$productType] = array(
            'block' => $blockType,
            'template' => $template,
            'blockInstance' => null
        );
        return $this;
    }

}
