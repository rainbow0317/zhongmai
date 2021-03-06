<?php
namespace SmartJson\Pdd\Api\Request;

use \SmartJson\Pdd\PopBaseHttpRequest;
use \SmartJson\Pdd\PopBaseJsonEntity;

class PddDdkOauthMallUrlGenRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "mall_id")
	*/
	private $mallId;

	/**
	* @JsonProperty(String, "pid")
	*/
	private $pid;

	/**
	* @JsonProperty(Boolean, "generate_weapp_webview")
	*/
	private $generateWeappWebview;

	/**
	* @JsonProperty(Boolean, "generate_short_url")
	*/
	private $generateShortUrl;

	/**
	* @JsonProperty(Boolean, "multi_group")
	*/
	private $multiGroup;

	/**
	* @JsonProperty(String, "custom_parameters")
	*/
	private $customParameters;

	/**
	* @JsonProperty(Boolean, "generate_mall_collect_coupon")
	*/
	private $generateMallCollectCoupon;

	/**
	* @JsonProperty(Boolean, "generate_schema_url")
	*/
	private $generateSchemaUrl;

	/**
	* @JsonProperty(Boolean, "generate_qq_app")
	*/
	private $generateQqApp;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "mall_id", $this->mallId);
		$this->setUserParam($params, "pid", $this->pid);
		$this->setUserParam($params, "generate_weapp_webview", $this->generateWeappWebview);
		$this->setUserParam($params, "generate_short_url", $this->generateShortUrl);
		$this->setUserParam($params, "multi_group", $this->multiGroup);
		$this->setUserParam($params, "custom_parameters", $this->customParameters);
		$this->setUserParam($params, "generate_mall_collect_coupon", $this->generateMallCollectCoupon);
		$this->setUserParam($params, "generate_schema_url", $this->generateSchemaUrl);
		$this->setUserParam($params, "generate_qq_app", $this->generateQqApp);

	}

	public function getVersion()
	{
		return "V1";
	}

	public function getDataType()
	{
		return "JSON";
	}

	public function getType()
	{
		return "pdd.ddk.oauth.mall.url.gen";
	}

	public function setMallId($mallId)
	{
		$this->mallId = $mallId;
	}

	public function setPid($pid)
	{
		$this->pid = $pid;
	}

	public function setGenerateWeappWebview($generateWeappWebview)
	{
		$this->generateWeappWebview = $generateWeappWebview;
	}

	public function setGenerateShortUrl($generateShortUrl)
	{
		$this->generateShortUrl = $generateShortUrl;
	}

	public function setMultiGroup($multiGroup)
	{
		$this->multiGroup = $multiGroup;
	}

	public function setCustomParameters($customParameters)
	{
		$this->customParameters = $customParameters;
	}

	public function setGenerateMallCollectCoupon($generateMallCollectCoupon)
	{
		$this->generateMallCollectCoupon = $generateMallCollectCoupon;
	}

	public function setGenerateSchemaUrl($generateSchemaUrl)
	{
		$this->generateSchemaUrl = $generateSchemaUrl;
	}

	public function setGenerateQqApp($generateQqApp)
	{
		$this->generateQqApp = $generateQqApp;
	}

}
