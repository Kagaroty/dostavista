<?php

namespace Dostavista;

class OrderRequest extends BaseOrder
{
    public function __construct(string $matter, array $config = [])
    {
        parent::__construct($config);
        $this->setMatter($matter);
    }

    /**
     * @param string $matter
     *
     * @return $this
     */
    public function setMatter(string $matter)
    {
        $this->matter = $matter;
        return $this;
    }

    /**
     * @param int $vehicleTypeId 
     *
     * @return $this
     */
    public function setVehicleType(int $vehicleTypeId)
    {
        $this->vehicleTypeId = $vehicleTypeId;
        return $this;
    }

    /**
     * [setTotalWeightKg description]
     * @param int|integer $totalWeightKg [description]
     */
    public function setTotalWeight (string $totalWeight)
    {
        $this->totalWeightKg = $totalWeight;
        return $this;
    }

    /**
     * @param int $insurance
     *
     * @return $this
     */
    public function setInsuranceAmount(int $insuranceAmount)
    {
        $this->insuranceAmount  = $insuranceAmount;
        return $this;
    }

    /**
     * @param bool $recipientsSmsNotification
     *
     * @return $this
     */
    public function setIsClientNotificationEnabled(bool $isClientNotificationEnabled)
    {
        $this->isClientNotificationEnabled = $isClientNotificationEnabled;
        return $this;
    }

    /**
     * @param bool $recipientsSmsNotification
     *
     * @return $this
     */
    public function setIsContactPersonNotificationEnabled(bool $isContactPersonNotificationEnabled)
    {
        $this->isContactPersonNotificationEnabled = $isContactPersonNotificationEnabled;
        return $this;
    }

    public function setLoadersCount(int $loadersCount)
    {
        $this->loadersCount = $loadersCount;
        return $this;
    }

    /**
     * @param string $backpaymentDetails
     *
     * @return $this
     */
    public function setBackpaymentDetails(string $backpaymentDetails)
    {
        $this->backpaymentDetails = $backpaymentDetails;
        return $this;
    }
}