<?php

class ServiceList
{
    /** @param Drupal\Core\Access\AccessArgumentsResolverFactory ACCESS_ARGUMENTS_RESOLVER_FACTORY */
    public const ACCESS_ARGUMENTS_RESOLVER_FACTORY = "access_arguments_resolver_factory";

    /** @param Drupal\Core\Access\CsrfAccessCheck ACCESS_CHECK_CSRF */
    public const ACCESS_CHECK_CSRF = "access_check.csrf";

    /** @param Drupal\Core\Access\CustomAccessCheck ACCESS_CHECK_CUSTOM */
    public const ACCESS_CHECK_CUSTOM = "access_check.custom";

    /** @param Drupal\Core\Access\DefaultAccessCheck ACCESS_CHECK_DEFAULT */
    public const ACCESS_CHECK_DEFAULT = "access_check.default";

    /** @param Drupal\Core\Entity\EntityAccessCheck ACCESS_CHECK_ENTITY */
    public const ACCESS_CHECK_ENTITY = "access_check.entity";

    /** @param Drupal\Core\Entity\EntityBundleAccessCheck ACCESS_CHECK_ENTITY_BUNDLES */
    public const ACCESS_CHECK_ENTITY_BUNDLES = "access_check.entity_bundles";

    /** @param Drupal\Core\Entity\EntityCreateAccessCheck ACCESS_CHECK_ENTITY_CREATE */
    public const ACCESS_CHECK_ENTITY_CREATE = "access_check.entity_create";

    /** @param Drupal\Core\Entity\EntityCreateAnyAccessCheck ACCESS_CHECK_ENTITY_CREATE_ANY */
    public const ACCESS_CHECK_ENTITY_CREATE_ANY = "access_check.entity_create_any";

    /** @param Drupal\Core\Entity\EntityDeleteMultipleAccessCheck ACCESS_CHECK_ENTITY_DELETE_MULTIPLE */
    public const ACCESS_CHECK_ENTITY_DELETE_MULTIPLE = "access_check.entity_delete_multiple";

    /** @param Drupal\Core\Access\CsrfRequestHeaderAccessCheck ACCESS_CHECK_HEADER_CSRF */
    public const ACCESS_CHECK_HEADER_CSRF = "access_check.header.csrf";

    /** @param Drupal\Core\Theme\ThemeAccessCheck ACCESS_CHECK_THEME */
    public const ACCESS_CHECK_THEME = "access_check.theme";

    /** @param Drupal\Core\Access\CheckProvider ACCESS_MANAGER_CHECK_PROVIDER */
    public const ACCESS_MANAGER_CHECK_PROVIDER = "access_manager.check_provider";

    /** @param Drupal\Core\Session\AccountSwitcher ACCOUNT_SWITCHER */
    public const ACCOUNT_SWITCHER = "account_switcher";

    /** @param Drupal\Core\Ajax\AjaxResponseAttachmentsProcessor AJAX_RESPONSE_ATTACHMENTS_PROCESSOR */
    public const AJAX_RESPONSE_ATTACHMENTS_PROCESSOR = "ajax_response.attachments_processor";

    /** @param Drupal\Core\EventSubscriber\AjaxResponseSubscriber AJAX_RESPONSE_SUBSCRIBER */
    public const AJAX_RESPONSE_SUBSCRIBER = "ajax_response.subscriber";

    /** @param Drupal\Core\EventSubscriber\AnonymousUserResponseSubscriber ANONYMOUS_USER_RESPONSE_SUBSCRIBER */
    public const ANONYMOUS_USER_RESPONSE_SUBSCRIBER = "anonymous_user_response_subscriber";

    /** @param Drupal\Core\AppRootFactory APP_ROOT_FACTORY */
    public const APP_ROOT_FACTORY = "app.root.factory";

    /** @param Drupal\Core\Asset\CssCollectionGrouper ASSET_CSS_COLLECTION_GROUPER */
    public const ASSET_CSS_COLLECTION_GROUPER = "asset.css.collection_grouper";

    /** @param Drupal\Core\Asset\CssCollectionOptimizer ASSET_CSS_COLLECTION_OPTIMIZER */
    public const ASSET_CSS_COLLECTION_OPTIMIZER = "asset.css.collection_optimizer";

    /** @param Drupal\Core\Asset\AssetDumper ASSET_CSS_DUMPER */
    public const ASSET_CSS_DUMPER = "asset.css.dumper";

    /** @param Drupal\Core\Asset\CssOptimizer ASSET_CSS_OPTIMIZER */
    public const ASSET_CSS_OPTIMIZER = "asset.css.optimizer";

    /** @param Drupal\Core\Asset\JsCollectionGrouper ASSET_JS_COLLECTION_GROUPER */
    public const ASSET_JS_COLLECTION_GROUPER = "asset.js.collection_grouper";

    /** @param Drupal\Core\Asset\JsCollectionOptimizer ASSET_JS_COLLECTION_OPTIMIZER */
    public const ASSET_JS_COLLECTION_OPTIMIZER = "asset.js.collection_optimizer";

    /** @param Drupal\Core\Asset\AssetDumper ASSET_JS_DUMPER */
    public const ASSET_JS_DUMPER = "asset.js.dumper";

    /** @param Drupal\Core\Asset\JsOptimizer ASSET_JS_OPTIMIZER */
    public const ASSET_JS_OPTIMIZER = "asset.js.optimizer";

    /** @param Drupal\Core\Asset\AssetResolver ASSET_RESOLVER */
    public const ASSET_RESOLVER = "asset.resolver";

    /** @param Drupal\Core\Authentication\AuthenticationManager AUTHENTICATION */
    public const AUTHENTICATION = "authentication";

    /** @param Drupal\Core\Authentication\AuthenticationCollector AUTHENTICATION_COLLECTOR */
    public const AUTHENTICATION_COLLECTOR = "authentication_collector";

    /** @param Drupal\Core\EventSubscriber\AuthenticationSubscriber AUTHENTICATION_SUBSCRIBER */
    public const AUTHENTICATION_SUBSCRIBER = "authentication_subscriber";

    /** @param Drupal\Core\ProxyClass\Render\BareHtmlPageRenderer BARE_HTML_PAGE_RENDERER */
    public const BARE_HTML_PAGE_RENDERER = "bare_html_page_renderer";

    /** @param Drupal\Core\ProxyClass\Batch\BatchStorage BATCH_STORAGE */
    public const BATCH_STORAGE = "batch.storage";

    /** @param Drupal\Core\Breadcrumb\BreadcrumbManager BREADCRUMB */
    public const BREADCRUMB = "breadcrumb";

    /** @param Drupal\Core\Cache\ApcuBackendFactory CACHE_BACKEND_APCU */
    public const CACHE_BACKEND_APCU = "cache.backend.apcu";

    /** @param Drupal\Core\Cache\ChainedFastBackendFactory CACHE_BACKEND_CHAINEDFAST */
    public const CACHE_BACKEND_CHAINEDFAST = "cache.backend.chainedfast";

    /** @param Drupal\Core\Cache\DatabaseBackendFactory CACHE_BACKEND_DATABASE */
    public const CACHE_BACKEND_DATABASE = "cache.backend.database";

    /** @param Drupal\Core\Cache\MemoryBackendFactory CACHE_BACKEND_MEMORY */
    public const CACHE_BACKEND_MEMORY = "cache.backend.memory";

    /** @param Drupal\Core\Cache\NullBackendFactory CACHE_BACKEND_null */
    public const CACHE_BACKEND_null = "cache.backend.null";

    /** @param Drupal\Core\Cache\PhpBackendFactory CACHE_BACKEND_PHP */
    public const CACHE_BACKEND_PHP = "cache.backend.php";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_BOOTSTRAP */
    public const CACHE_BOOTSTRAP = "cache.bootstrap";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_CONFIG */
    public const CACHE_CONFIG = "cache.config";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_DATA */
    public const CACHE_DATA = "cache.data";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_DEFAULT */
    public const CACHE_DEFAULT = "cache.default";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_DISCOVERY */
    public const CACHE_DISCOVERY = "cache.discovery";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_ENTITY */
    public const CACHE_ENTITY = "cache.entity";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_JSONAPI_NORMALIZATIONS */
    public const CACHE_JSONAPI_NORMALIZATIONS = "cache.jsonapi_normalizations";

    /** @param Drupal\Core\Cache\BackendChain CACHE_JSONAPI_RESOURCE_TYPES */
    public const CACHE_JSONAPI_RESOURCE_TYPES = "cache.jsonapi_resource_types";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_MENU */
    public const CACHE_MENU = "cache.menu";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_PERMISSIONS_BY_TERM */
    public const CACHE_PERMISSIONS_BY_TERM = "cache.permissions_by_term";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_RENDER */
    public const CACHE_RENDER = "cache.render";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_REST */
    public const CACHE_REST = "cache.rest";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_STATIC */
    public const CACHE_STATIC = "cache.static";

    /** @param Drupal\Core\Cache\CacheBackendInterface CACHE_TOOLBAR */
    public const CACHE_TOOLBAR = "cache.toolbar";

    /** @param Drupal\Core\Cache\Context\CookiesCacheContext CACHE_CONTEXT_COOKIES */
    public const CACHE_CONTEXT_COOKIES = "cache_context.cookies";

    /** @param Drupal\Core\Cache\Context\HeadersCacheContext CACHE_CONTEXT_HEADERS */
    public const CACHE_CONTEXT_HEADERS = "cache_context.headers";

    /** @param Drupal\Core\Cache\Context\IpCacheContext CACHE_CONTEXT_IP */
    public const CACHE_CONTEXT_IP = "cache_context.ip";

    /** @param Drupal\Core\Cache\Context\LanguagesCacheContext CACHE_CONTEXT_LANGUAGES */
    public const CACHE_CONTEXT_LANGUAGES = "cache_context.languages";

    /** @param Drupal\Core\Cache\Context\ProtocolVersionCacheContext CACHE_CONTEXT_PROTOCOL_VERSION */
    public const CACHE_CONTEXT_PROTOCOL_VERSION = "cache_context.protocol_version";

    /** @param Drupal\Core\Cache\Context\RequestFormatCacheContext CACHE_CONTEXT_REQUEST_FORMAT */
    public const CACHE_CONTEXT_REQUEST_FORMAT = "cache_context.request_format";

    /** @param Drupal\Core\Cache\Context\RouteCacheContext CACHE_CONTEXT_ROUTE */
    public const CACHE_CONTEXT_ROUTE = "cache_context.route";

    /** @param Drupal\Core\Cache\Context\MenuActiveTrailsCacheContext CACHE_CONTEXT_ROUTE_MENU_ACTIVE_TRAILS */
    public const CACHE_CONTEXT_ROUTE_MENU_ACTIVE_TRAILS = "cache_context.route.menu_active_trails";

    /** @param Drupal\Core\Cache\Context\RouteNameCacheContext CACHE_CONTEXT_ROUTE_NAME */
    public const CACHE_CONTEXT_ROUTE_NAME = "cache_context.route.name";

    /** @param Drupal\Core\Cache\Context\SessionCacheContext CACHE_CONTEXT_SESSION */
    public const CACHE_CONTEXT_SESSION = "cache_context.session";

    /** @param Drupal\Core\Cache\Context\SessionExistsCacheContext CACHE_CONTEXT_SESSION_EXISTS */
    public const CACHE_CONTEXT_SESSION_EXISTS = "cache_context.session.exists";

    /** @param Drupal\Core\Cache\Context\ThemeCacheContext CACHE_CONTEXT_THEME */
    public const CACHE_CONTEXT_THEME = "cache_context.theme";

    /** @param Drupal\Core\Cache\Context\TimeZoneCacheContext CACHE_CONTEXT_TIMEZONE */
    public const CACHE_CONTEXT_TIMEZONE = "cache_context.timezone";

    /** @param Drupal\Core\Cache\Context\UrlCacheContext CACHE_CONTEXT_URL */
    public const CACHE_CONTEXT_URL = "cache_context.url";

    /** @param Drupal\Core\Cache\Context\PathCacheContext CACHE_CONTEXT_URL_PATH */
    public const CACHE_CONTEXT_URL_PATH = "cache_context.url.path";

    /** @param Drupal\Core\Cache\Context\IsFrontPathCacheContext CACHE_CONTEXT_URL_PATH_IS_FRONT */
    public const CACHE_CONTEXT_URL_PATH_IS_FRONT = "cache_context.url.path.is_front";

    /** @param Drupal\Core\Cache\Context\PathParentCacheContext CACHE_CONTEXT_URL_PATH_PARENT */
    public const CACHE_CONTEXT_URL_PATH_PARENT = "cache_context.url.path.parent";

    /** @param Drupal\Core\Cache\Context\QueryArgsCacheContext CACHE_CONTEXT_URL_QUERY_ARGS */
    public const CACHE_CONTEXT_URL_QUERY_ARGS = "cache_context.url.query_args";

    /** @param Drupal\Core\Cache\Context\PagersCacheContext CACHE_CONTEXT_URL_QUERY_ARGS_PAGERS */
    public const CACHE_CONTEXT_URL_QUERY_ARGS_PAGERS = "cache_context.url.query_args.pagers";

    /** @param Drupal\Core\Cache\Context\SiteCacheContext CACHE_CONTEXT_URL_SITE */
    public const CACHE_CONTEXT_URL_SITE = "cache_context.url.site";

    /** @param Drupal\Core\Cache\Context\UserCacheContext CACHE_CONTEXT_USER */
    public const CACHE_CONTEXT_USER = "cache_context.user";

    /** @param Drupal\Core\Cache\Context\IsSuperUserCacheContext CACHE_CONTEXT_USER_IS_SUPER_USER */
    public const CACHE_CONTEXT_USER_IS_SUPER_USER = "cache_context.user.is_super_user";

    /** @param Drupal\Core\Cache\Context\AccountPermissionsCacheContext CACHE_CONTEXT_USER_PERMISSIONS */
    public const CACHE_CONTEXT_USER_PERMISSIONS = "cache_context.user.permissions";

    /** @param Drupal\Core\Cache\Context\UserRolesCacheContext CACHE_CONTEXT_USER_ROLES */
    public const CACHE_CONTEXT_USER_ROLES = "cache_context.user.roles";

    /** @param Drupal\Core\Cache\Context\CacheContextsManager CACHE_CONTEXTS_MANAGER */
    public const CACHE_CONTEXTS_MANAGER = "cache_contexts_manager";

    /** @param Drupal\Core\EventSubscriber\CacheRouterRebuildSubscriber CACHE_ROUTER_REBUILD_SUBSCRIBER */
    public const CACHE_ROUTER_REBUILD_SUBSCRIBER = "cache_router_rebuild_subscriber";

    /** @param Drupal\Core\Cache\CacheTagsInvalidator CACHE_TAGS_INVALIDATOR */
    public const CACHE_TAGS_INVALIDATOR = "cache_tags.invalidator";

    /** @param Drupal\Core\Cache\DatabaseCacheTagsChecksum CACHE_TAGS_INVALIDATOR_CHECKSUM */
    public const CACHE_TAGS_INVALIDATOR_CHECKSUM = "cache_tags.invalidator.checksum";

    /** @param Drupal\Core\DependencyInjection\ClassResolver CLASS_RESOLVER */
    public const CLASS_RESOLVER = "class_resolver";

    /** @param Drupal\Core\EventSubscriber\ClientErrorResponseSubscriber CLIENT_ERROR_RESPONSE_SUBSCRIBER */
    public const CLIENT_ERROR_RESPONSE_SUBSCRIBER = "client_error_response_subscriber";

    /** @param Drupal\Core\Config\ImportStorageTransformer CONFIG_IMPORT_TRANSFORMER */
    public const CONFIG_IMPORT_TRANSFORMER = "config.import_transformer";

    /** @param Drupal\Core\Config\Importer\FinalMissingContentSubscriber CONFIG_IMPORTER_SUBSCRIBER */
    public const CONFIG_IMPORTER_SUBSCRIBER = "config.importer_subscriber";

    /** @param Drupal\Core\ProxyClass\Config\ConfigInstaller CONFIG_INSTALLER */
    public const CONFIG_INSTALLER = "config.installer";

    /** @param Drupal\Core\Config\ConfigManager CONFIG_MANAGER */
    public const CONFIG_MANAGER = "config.manager";

    /** @param Drupal\Core\Config\CachedStorage CONFIG_STORAGE */
    public const CONFIG_STORAGE = "config.storage";

    /** @param Drupal\Core\Config\ManagedStorage CONFIG_STORAGE_EXPORT */
    public const CONFIG_STORAGE_EXPORT = "config.storage.export";

    /** @param Drupal\Core\Config\ExtensionInstallStorage CONFIG_STORAGE_SCHEMA */
    public const CONFIG_STORAGE_SCHEMA = "config.storage.schema";

    /** @param Drupal\Core\Config\DatabaseStorage CONFIG_STORAGE_SNAPSHOT */
    public const CONFIG_STORAGE_SNAPSHOT = "config.storage.snapshot";

    /** @param Drupal\Core\Config\FileStorage CONFIG_STORAGE_SYNC */
    public const CONFIG_STORAGE_SYNC = "config.storage.sync";

    /** @param Drupal\Core\Config\TypedConfigManager CONFIG_TYPED */
    public const CONFIG_TYPED = "config.typed";

    /** @param Drupal\Core\EventSubscriber\ExcludedModulesEventSubscriber CONFIG_EXCLUDE_MODULES_SUBSCRIBER */
    public const CONFIG_EXCLUDE_MODULES_SUBSCRIBER = "config_exclude_modules_subscriber";

    /** @param Drupal\Core\EventSubscriber\ConfigImportSubscriber CONFIG_IMPORT_SUBSCRIBER */
    public const CONFIG_IMPORT_SUBSCRIBER = "config_import_subscriber";

    /** @param Drupal\Core\EventSubscriber\ConfigSnapshotSubscriber CONFIG_SNAPSHOT_SUBSCRIBER */
    public const CONFIG_SNAPSHOT_SUBSCRIBER = "config_snapshot_subscriber";

    /** @param Drupal\Core\Routing\ContentTypeHeaderMatcher CONTENT_TYPE_HEADER_MATCHER */
    public const CONTENT_TYPE_HEADER_MATCHER = "content_type_header_matcher";

    /** @param Drupal\Core\ProxyClass\Entity\ContentUninstallValidator CONTENT_UNINSTALL_VALIDATOR */
    public const CONTENT_UNINSTALL_VALIDATOR = "content_uninstall_validator";

    /** @param Drupal\Core\Plugin\Context\ContextHandler CONTEXT_HANDLER */
    public const CONTEXT_HANDLER = "context.handler";

    /** @param Drupal\Core\Plugin\Context\LazyContextRepository CONTEXT_REPOSITORY */
    public const CONTEXT_REPOSITORY = "context.repository";

    /** @param Drupal\Core\Entity\HtmlEntityFormController CONTROLLER_ENTITY_FORM */
    public const CONTROLLER_ENTITY_FORM = "controller.entity_form";

    /** @param Drupal\Core\Controller\HtmlFormController CONTROLLER_FORM */
    public const CONTROLLER_FORM = "controller.form";

    /** @param Drupal\Core\Controller\ControllerResolver CONTROLLER_RESOLVER */
    public const CONTROLLER_RESOLVER = "controller_resolver";

    /** @param Drupal\Core\Locale\CountryManager COUNTRY_MANAGER */
    public const COUNTRY_MANAGER = "country_manager";

    /** @param Drupal\Core\ProxyClass\Cron CRON */
    public const CRON = "cron";

    /** @param Drupal\Core\Access\CsrfTokenGenerator CSRF_TOKEN */
    public const CSRF_TOKEN = "csrf_token";

    /** @param Drupal\Core\Routing\CurrentRouteMatch CURRENT_ROUTE_MATCH */
    public const CURRENT_ROUTE_MATCH = "current_route_match";

    /** @param Drupal\Core\Session\AccountProxy CURRENT_USER */
    public const CURRENT_USER = "current_user";

    /** @param Drupal\Core\Cache\CacheBackendInterface DATA_FACTORY_STORE_CACHE */
    public const DATA_FACTORY_STORE_CACHE = "data_factory.store_cache";

    /** @param Drupal\Core\Database\Connection DATABASE */
    public const DATABASE = "database";

    /** @param Drupal\Core\Database\Connection DATABASE_REPLICA */
    public const DATABASE_REPLICA = "database.replica";

    /** @param Drupal\Core\Database\ReplicaKillSwitch DATABASE_REPLICA_KILL_SWITCH */
    public const DATABASE_REPLICA_KILL_SWITCH = "database.replica_kill_switch";

    /** @param Drupal\Core\Datetime\DateFormatter DATE_FORMATTER */
    public const DATE_FORMATTER = "date.formatter";

    /** @param Drupal\Core\Diff\DiffFormatter DIFF_FORMATTER */
    public const DIFF_FORMATTER = "diff.formatter";

    /** @param Drupal\Core\Render\BareHtmlPageRenderer DRUPAL_PROXY_ORIGINAL_SERVICE_BARE_HTML_PAGE_RENDERER */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_BARE_HTML_PAGE_RENDERER = "drupal.proxy_original_service.bare_html_page_renderer";

    /** @param Drupal\Core\Batch\BatchStorage DRUPAL_PROXY_ORIGINAL_SERVICE_BATCH_STORAGE */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_BATCH_STORAGE = "drupal.proxy_original_service.batch.storage";

    /** @param Drupal\Core\Config\ConfigInstaller DRUPAL_PROXY_ORIGINAL_SERVICE_CONFIG_INSTALLER */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_CONFIG_INSTALLER = "drupal.proxy_original_service.config.installer";

    /** @param Drupal\Core\Entity\ContentUninstallValidator DRUPAL_PROXY_ORIGINAL_SERVICE_CONTENT_UNINSTALL_VALIDATOR */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_CONTENT_UNINSTALL_VALIDATOR = "drupal.proxy_original_service.content_uninstall_validator";

    /** @param Drupal\Core\Cron DRUPAL_PROXY_ORIGINAL_SERVICE_CRON */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_CRON = "drupal.proxy_original_service.cron";

    /** @param Drupal\Core\File\MimeType\MimeTypeGuesser DRUPAL_PROXY_ORIGINAL_SERVICE_FILE_MIME_TYPE_GUESSER */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_FILE_MIME_TYPE_GUESSER = "drupal.proxy_original_service.file.mime_type.guesser";

    /** @param Drupal\Core\File\MimeType\ExtensionMimeTypeGuesser DRUPAL_PROXY_ORIGINAL_SERVICE_FILE_MIME_TYPE_GUESSER_EXTENSION */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_FILE_MIME_TYPE_GUESSER_EXTENSION = "drupal.proxy_original_service.file.mime_type.guesser.extension";

    /** @param Drupal\Core\Lock\DatabaseLockBackend DRUPAL_PROXY_ORIGINAL_SERVICE_LOCK */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_LOCK = "drupal.proxy_original_service.lock";

    /** @param Drupal\Core\Lock\PersistentDatabaseLockBackend DRUPAL_PROXY_ORIGINAL_SERVICE_LOCK_PERSISTENT */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_LOCK_PERSISTENT = "drupal.proxy_original_service.lock.persistent";

    /** @param Drupal\Core\Extension\ModuleInstaller DRUPAL_PROXY_ORIGINAL_SERVICE_MODULE_INSTALLER */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_MODULE_INSTALLER = "drupal.proxy_original_service.module_installer";

    /** @param Drupal\Core\Extension\ModuleRequiredByThemesUninstallValidator DRUPAL_PROXY_ORIGINAL_SERVICE_MODULE_REQUIRED_BY_THEMES_UNINSTALL_VALIDATOR */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_MODULE_REQUIRED_BY_THEMES_UNINSTALL_VALIDATOR = "drupal.proxy_original_service.module_required_by_themes_uninstall_validator";

    /** @param Drupal\Core\PageCache\ChainResponsePolicy DRUPAL_PROXY_ORIGINAL_SERVICE_PAGE_CACHE_RESPONSE_POLICY */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_PAGE_CACHE_RESPONSE_POLICY = "drupal.proxy_original_service.page_cache_response_policy";

    /** @param Drupal\Core\ParamConverter\AdminPathConfigEntityConverter DRUPAL_PROXY_ORIGINAL_SERVICE_PARAMCONVERTER_CONFIGENTITY_ADMIN */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_PARAMCONVERTER_CONFIGENTITY_ADMIN = "drupal.proxy_original_service.paramconverter.configentity_admin";

    /** @param Drupal\Core\ParamConverter\MenuLinkPluginConverter DRUPAL_PROXY_ORIGINAL_SERVICE_PARAMCONVERTER_MENU_LINK */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_PARAMCONVERTER_MENU_LINK = "drupal.proxy_original_service.paramconverter.menu_link";

    /** @param Drupal\Core\Plugin\CachedDiscoveryClearer DRUPAL_PROXY_ORIGINAL_SERVICE_PLUGIN_CACHE_CLEARER */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_PLUGIN_CACHE_CLEARER = "drupal.proxy_original_service.plugin.cache_clearer";

    /** @param Drupal\Core\Extension\RequiredModuleUninstallValidator DRUPAL_PROXY_ORIGINAL_SERVICE_REQUIRED_MODULE_UNINSTALL_VALIDATOR */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_REQUIRED_MODULE_UNINSTALL_VALIDATOR = "drupal.proxy_original_service.required_module_uninstall_validator";

    /** @param Drupal\Core\Routing\RouteBuilder DRUPAL_PROXY_ORIGINAL_SERVICE_ROUTER_BUILDER */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_ROUTER_BUILDER = "drupal.proxy_original_service.router.builder";

    /** @param Drupal\Core\Routing\MatcherDumper DRUPAL_PROXY_ORIGINAL_SERVICE_ROUTER_DUMPER */
    public const DRUPAL_PROXY_ORIGINAL_SERVICE_ROUTER_DUMPER = "drupal.proxy_original_service.router.dumper";

    /** @param Drupal\Core\EventSubscriber\EarlyRenderingControllerWrapperSubscriber EARLY_RENDERING_CONTROLLER_WRAPPER_SUBSCRIBER */
    public const EARLY_RENDERING_CONTROLLER_WRAPPER_SUBSCRIBER = "early_rendering_controller_wrapper_subscriber";

    /** @param Drupal\Core\Entity\EntityAutocompleteMatcher ENTITY_AUTOCOMPLETE_MATCHER */
    public const ENTITY_AUTOCOMPLETE_MATCHER = "entity.autocomplete_matcher";

    /** @param Drupal\Core\Entity\Event\BundleConfigImportValidate ENTITY_BUNDLE_CONFIG_IMPORT_VALIDATOR */
    public const ENTITY_BUNDLE_CONFIG_IMPORT_VALIDATOR = "entity.bundle_config_import_validator";

    /** @param Drupal\Core\Entity\EntityDefinitionUpdateManager ENTITY_DEFINITION_UPDATE_MANAGER */
    public const ENTITY_DEFINITION_UPDATE_MANAGER = "entity.definition_update_manager";

    /** @param Drupal\Core\Entity\EntityFormBuilder ENTITY_FORM_BUILDER */
    public const ENTITY_FORM_BUILDER = "entity.form_builder";

    /** @param Drupal\Core\Entity\EntityLastInstalledSchemaRepository ENTITY_LAST_INSTALLED_SCHEMA_REPOSITORY */
    public const ENTITY_LAST_INSTALLED_SCHEMA_REPOSITORY = "entity.last_installed_schema.repository";

    /** @param Drupal\Core\Cache\MemoryCache\MemoryCache ENTITY_MEMORY_CACHE */
    public const ENTITY_MEMORY_CACHE = "entity.memory_cache";

    /** @param Drupal\Core\Config\Entity\Query\QueryFactory ENTITY_QUERY_CONFIG */
    public const ENTITY_QUERY_CONFIG = "entity.query.config";

    /** @param Drupal\Core\Entity\KeyValueStore\Query\QueryFactory ENTITY_QUERY_KEYVALUE */
    public const ENTITY_QUERY_KEYVALUE = "entity.query.keyvalue";

    /** @param Drupal\Core\Entity\Query\Null\QueryFactory ENTITY_QUERY_NULL */
    public const ENTITY_QUERY_NULL = "entity.query.null";

    /** @param Drupal\Core\Entity\Query\Sql\QueryFactory ENTITY_QUERY_SQL */
    public const ENTITY_QUERY_SQL = "entity.query.sql";

    /** @param Drupal\Core\Entity\EntityRepository ENTITY_REPOSITORY */
    public const ENTITY_REPOSITORY = "entity.repository";

    /** @param Drupal\Core\Entity\EntityBundleListener ENTITY_BUNDLE_LISTENER */
    public const ENTITY_BUNDLE_LISTENER = "entity_bundle.listener";

    /** @param Drupal\Core\Entity\EntityDisplayRepository ENTITY_DISPLAY_REPOSITORY */
    public const ENTITY_DISPLAY_REPOSITORY = "entity_display.repository";

    /** @param Drupal\Core\Field\DeletedFieldsRepository ENTITY_FIELD_DELETED_FIELDS_REPOSITORY */
    public const ENTITY_FIELD_DELETED_FIELDS_REPOSITORY = "entity_field.deleted_fields_repository";

    /** @param Drupal\Core\Entity\EntityFieldManager ENTITY_FIELD_MANAGER */
    public const ENTITY_FIELD_MANAGER = "entity_field.manager";

    /** @param Drupal\Core\EventSubscriber\EntityRouteProviderSubscriber ENTITY_ROUTE_SUBSCRIBER */
    public const ENTITY_ROUTE_SUBSCRIBER = "entity_route_subscriber";

    /** @param Drupal\Core\Entity\EntityTypeBundleInfo ENTITY_TYPE_BUNDLE_INFO */
    public const ENTITY_TYPE_BUNDLE_INFO = "entity_type.bundle.info";

    /** @param Drupal\Core\Entity\EntityTypeListener ENTITY_TYPE_LISTENER */
    public const ENTITY_TYPE_LISTENER = "entity_type.listener";

    /** @param Drupal\Core\Entity\EntityTypeRepository ENTITY_TYPE_REPOSITORY */
    public const ENTITY_TYPE_REPOSITORY = "entity_type.repository";

    /** @param Drupal\Core\EventSubscriber\CustomPageExceptionHtmlSubscriber EXCEPTION_CUSTOM_PAGE_HTML */
    public const EXCEPTION_CUSTOM_PAGE_HTML = "exception.custom_page_html";

    /** @param Drupal\Core\EventSubscriber\DefaultExceptionHtmlSubscriber EXCEPTION_DEFAULT_HTML */
    public const EXCEPTION_DEFAULT_HTML = "exception.default_html";

    /** @param Drupal\Core\EventSubscriber\ExceptionJsonSubscriber EXCEPTION_DEFAULT_JSON */
    public const EXCEPTION_DEFAULT_JSON = "exception.default_json";

    /** @param Drupal\Core\EventSubscriber\EnforcedFormResponseSubscriber EXCEPTION_ENFORCED_FORM_RESPONSE */
    public const EXCEPTION_ENFORCED_FORM_RESPONSE = "exception.enforced_form_response";

    /** @param Drupal\Core\EventSubscriber\Fast404ExceptionHtmlSubscriber EXCEPTION_FAST_404_HTML */
    public const EXCEPTION_FAST_404_HTML = "exception.fast_404_html";

    /** @param Drupal\Core\EventSubscriber\FinalExceptionSubscriber EXCEPTION_FINAL */
    public const EXCEPTION_FINAL = "exception.final";

    /** @param Drupal\Core\EventSubscriber\ExceptionLoggingSubscriber EXCEPTION_LOGGER */
    public const EXCEPTION_LOGGER = "exception.logger";

    /** @param Drupal\Core\EventSubscriber\ExceptionDetectNeedsInstallSubscriber EXCEPTION_NEEDS_INSTALLER */
    public const EXCEPTION_NEEDS_INSTALLER = "exception.needs_installer";

    /** @param Drupal\Core\EventSubscriber\ExceptionTestSiteSubscriber EXCEPTION_TEST_SITE */
    public const EXCEPTION_TEST_SITE = "exception.test_site";

    /** @param Drupal\Core\Extension\ModuleExtensionList EXTENSION_LIST_MODULE */
    public const EXTENSION_LIST_MODULE = "extension.list.module";

    /** @param Drupal\Core\Extension\ProfileExtensionList EXTENSION_LIST_PROFILE */
    public const EXTENSION_LIST_PROFILE = "extension.list.profile";

    /** @param Drupal\Core\Extension\ThemeExtensionList EXTENSION_LIST_THEME */
    public const EXTENSION_LIST_THEME = "extension.list.theme";

    /** @param Drupal\Core\Extension\ThemeEngineExtensionList EXTENSION_LIST_THEME_ENGINE */
    public const EXTENSION_LIST_THEME_ENGINE = "extension.list.theme_engine";

    /** @param Drupal\Core\Field\FieldDefinitionListener FIELD_DEFINITION_LISTENER */
    public const FIELD_DEFINITION_LISTENER = "field_definition.listener";

    /** @param Drupal\Core\Field\FieldStorageDefinitionListener FIELD_STORAGE_DEFINITION_LISTENER */
    public const FIELD_STORAGE_DEFINITION_LISTENER = "field_storage_definition.listener";

    /** @param Drupal\Core\File\HtaccessWriter FILE_HTACCESS_WRITER */
    public const FILE_HTACCESS_WRITER = "file.htaccess_writer";

    /** @param Drupal\Core\ProxyClass\File\MimeType\MimeTypeGuesser FILE_MIME_TYPE_GUESSER */
    public const FILE_MIME_TYPE_GUESSER = "file.mime_type.guesser";

    /** @param Drupal\Core\ProxyClass\File\MimeType\ExtensionMimeTypeGuesser FILE_MIME_TYPE_GUESSER_EXTENSION */
    public const FILE_MIME_TYPE_GUESSER_EXTENSION = "file.mime_type.guesser.extension";

    /** @param Drupal\Core\File\FileSystem FILE_SYSTEM */
    public const FILE_SYSTEM = "file_system";

    /** @param Drupal\Core\EventSubscriber\FinishResponseSubscriber FINISH_RESPONSE_SUBSCRIBER */
    public const FINISH_RESPONSE_SUBSCRIBER = "finish_response_subscriber";

    /** @param Drupal\Core\Flood\DatabaseBackend FLOOD */
    public const FLOOD = "flood";

    /** @param Drupal\Core\Form\FormAjaxResponseBuilder FORM_AJAX_RESPONSE_BUILDER */
    public const FORM_AJAX_RESPONSE_BUILDER = "form_ajax_response_builder";

    /** @param Drupal\Core\Form\EventSubscriber\FormAjaxSubscriber FORM_AJAX_SUBSCRIBER */
    public const FORM_AJAX_SUBSCRIBER = "form_ajax_subscriber";

    /** @param Drupal\Core\Form\FormErrorHandler FORM_ERROR_HANDLER */
    public const FORM_ERROR_HANDLER = "form_error_handler";

    /** @param Drupal\Core\Form\FormSubmitter FORM_SUBMITTER */
    public const FORM_SUBMITTER = "form_submitter";

    /** @param Drupal\Core\Form\FormValidator FORM_VALIDATOR */
    public const FORM_VALIDATOR = "form_validator";

    /** @param Drupal\Core\Render\HtmlResponseAttachmentsProcessor HTML_RESPONSE_ATTACHMENTS_PROCESSOR */
    public const HTML_RESPONSE_ATTACHMENTS_PROCESSOR = "html_response.attachments_processor";

    /** @param Drupal\Core\EventSubscriber\HtmlResponsePlaceholderStrategySubscriber HTML_RESPONSE_PLACEHOLDER_STRATEGY_SUBSCRIBER */
    public const HTML_RESPONSE_PLACEHOLDER_STRATEGY_SUBSCRIBER = "html_response.placeholder_strategy_subscriber";

    /** @param Drupal\Core\EventSubscriber\HtmlResponseSubscriber HTML_RESPONSE_SUBSCRIBER */
    public const HTML_RESPONSE_SUBSCRIBER = "html_response.subscriber";

    /** @param Drupal\Core\Http\ClientFactory HTTP_CLIENT_FACTORY */
    public const HTTP_CLIENT_FACTORY = "http_client_factory";

    /** @param Drupal\Core\StackMiddleware\KernelPreHandle HTTP_MIDDLEWARE_KERNEL_PRE_HANDLE */
    public const HTTP_MIDDLEWARE_KERNEL_PRE_HANDLE = "http_middleware.kernel_pre_handle";

    /** @param Drupal\Core\StackMiddleware\NegotiationMiddleware HTTP_MIDDLEWARE_NEGOTIATION */
    public const HTTP_MIDDLEWARE_NEGOTIATION = "http_middleware.negotiation";

    /** @param Drupal\Core\StackMiddleware\ReverseProxyMiddleware HTTP_MIDDLEWARE_REVERSE_PROXY */
    public const HTTP_MIDDLEWARE_REVERSE_PROXY = "http_middleware.reverse_proxy";

    /** @param Drupal\Core\StackMiddleware\Session HTTP_MIDDLEWARE_SESSION */
    public const HTTP_MIDDLEWARE_SESSION = "http_middleware.session";

    /** @param Drupal\Core\Image\ImageFactory IMAGE_FACTORY */
    public const IMAGE_FACTORY = "image.factory";

    /** @param Drupal\Core\ImageToolkit\ImageToolkitManager IMAGE_TOOLKIT_MANAGER */
    public const IMAGE_TOOLKIT_MANAGER = "image.toolkit.manager";

    /** @param Drupal\Core\ImageToolkit\ImageToolkitOperationManager IMAGE_TOOLKIT_OPERATION_MANAGER */
    public const IMAGE_TOOLKIT_OPERATION_MANAGER = "image.toolkit.operation.manager";

    /** @param Drupal\Core\Extension\InfoParser INFO_PARSER */
    public const INFO_PARSER = "info_parser";

    /** @param Drupal\Core\EventSubscriber\KernelDestructionSubscriber KERNEL_DESTRUCT_SUBSCRIBER */
    public const KERNEL_DESTRUCT_SUBSCRIBER = "kernel_destruct_subscriber";

    /** @param Drupal\Core\KeyValueStore\KeyValueFactory KEYVALUE */
    public const KEYVALUE = "keyvalue";

    /** @param Drupal\Core\KeyValueStore\KeyValueDatabaseFactory KEYVALUE_DATABASE */
    public const KEYVALUE_DATABASE = "keyvalue.database";

    /** @param Drupal\Core\KeyValueStore\KeyValueExpirableFactory KEYVALUE_EXPIRABLE */
    public const KEYVALUE_EXPIRABLE = "keyvalue.expirable";

    /** @param Drupal\Core\KeyValueStore\KeyValueDatabaseExpirableFactory KEYVALUE_EXPIRABLE_DATABASE */
    public const KEYVALUE_EXPIRABLE_DATABASE = "keyvalue.expirable.database";

    /** @param Drupal\Core\Language\ContextProvider\CurrentLanguageContext LANGUAGE_CURRENT_LANGUAGE_CONTEXT */
    public const LANGUAGE_CURRENT_LANGUAGE_CONTEXT = "language.current_language_context";

    /** @param Drupal\Core\Language\LanguageDefault LANGUAGE_DEFAULT */
    public const LANGUAGE_DEFAULT = "language.default";

    /** @param Drupal\Core\Asset\LibraryDependencyResolver LIBRARY_DEPENDENCY_RESOLVER */
    public const LIBRARY_DEPENDENCY_RESOLVER = "library.dependency_resolver";

    /** @param Drupal\Core\Asset\LibraryDiscovery LIBRARY_DISCOVERY */
    public const LIBRARY_DISCOVERY = "library.discovery";

    /** @param Drupal\Core\Asset\LibraryDiscoveryCollector LIBRARY_DISCOVERY_COLLECTOR */
    public const LIBRARY_DISCOVERY_COLLECTOR = "library.discovery.collector";

    /** @param Drupal\Core\Asset\LibraryDiscoveryParser LIBRARY_DISCOVERY_PARSER */
    public const LIBRARY_DISCOVERY_PARSER = "library.discovery.parser";

    /** @param Drupal\Core\Asset\LibrariesDirectoryFileFinder LIBRARY_LIBRARIES_DIRECTORY_FILE_FINDER */
    public const LIBRARY_LIBRARIES_DIRECTORY_FILE_FINDER = "library.libraries_directory_file_finder";

    /** @param Drupal\Core\Utility\LinkGenerator LINK_GENERATOR */
    public const LINK_GENERATOR = "link_generator";

    /** @param Drupal\Core\ProxyClass\Lock\DatabaseLockBackend LOCK */
    public const LOCK = "lock";

    /** @param Drupal\Core\ProxyClass\Lock\PersistentDatabaseLockBackend LOCK_PERSISTENT */
    public const LOCK_PERSISTENT = "lock.persistent";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_CONSUMERS */
    public const LOGGER_CHANNEL_CONSUMERS = "logger.channel.consumers";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_CRON */
    public const LOGGER_CHANNEL_CRON = "logger.channel.cron";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_DEFAULT */
    public const LOGGER_CHANNEL_DEFAULT = "logger.channel.default";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_FILE */
    public const LOGGER_CHANNEL_FILE = "logger.channel.file";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_FORM */
    public const LOGGER_CHANNEL_FORM = "logger.channel.form";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_IMAGE */
    public const LOGGER_CHANNEL_IMAGE = "logger.channel.image";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_JSONAPI */
    public const LOGGER_CHANNEL_JSONAPI = "logger.channel.jsonapi";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_PERMISSIONS_BY_TERM */
    public const LOGGER_CHANNEL_PERMISSIONS_BY_TERM = "logger.channel.permissions_by_term";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_PHP */
    public const LOGGER_CHANNEL_PHP = "logger.channel.php";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_REST */
    public const LOGGER_CHANNEL_REST = "logger.channel.rest";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_SECURITY */
    public const LOGGER_CHANNEL_SECURITY = "logger.channel.security";

    /** @param Drupal\Core\Logger\LoggerChannel LOGGER_CHANNEL_WEBPROFILER */
    public const LOGGER_CHANNEL_WEBPROFILER = "logger.channel.webprofiler";

    /** @param Drupal\Core\Logger\LoggerChannelFactory LOGGER_FACTORY */
    public const LOGGER_FACTORY = "logger.factory";

    /** @param Drupal\Core\Logger\LogMessageParser LOGGER_LOG_MESSAGE_PARSER */
    public const LOGGER_LOG_MESSAGE_PARSER = "logger.log_message_parser";

    /** @param Drupal\Core\Render\MainContent\AjaxRenderer MAIN_CONTENT_RENDERER_AJAX */
    public const MAIN_CONTENT_RENDERER_AJAX = "main_content_renderer.ajax";

    /** @param Drupal\Core\Render\MainContent\DialogRenderer MAIN_CONTENT_RENDERER_DIALOG */
    public const MAIN_CONTENT_RENDERER_DIALOG = "main_content_renderer.dialog";

    /** @param Drupal\Core\Render\MainContent\HtmlRenderer MAIN_CONTENT_RENDERER_HTML */
    public const MAIN_CONTENT_RENDERER_HTML = "main_content_renderer.html";

    /** @param Drupal\Core\Render\MainContent\ModalRenderer MAIN_CONTENT_RENDERER_MODAL */
    public const MAIN_CONTENT_RENDERER_MODAL = "main_content_renderer.modal";

    /** @param Drupal\Core\Render\MainContent\OffCanvasRenderer MAIN_CONTENT_RENDERER_OFF_CANVAS */
    public const MAIN_CONTENT_RENDERER_OFF_CANVAS = "main_content_renderer.off_canvas";

    /** @param Drupal\Core\Render\MainContent\OffCanvasRenderer MAIN_CONTENT_RENDERER_OFF_CANVAS_TOP */
    public const MAIN_CONTENT_RENDERER_OFF_CANVAS_TOP = "main_content_renderer.off_canvas_top";

    /** @param Drupal\Core\EventSubscriber\MainContentViewSubscriber MAIN_CONTENT_VIEW_SUBSCRIBER */
    public const MAIN_CONTENT_VIEW_SUBSCRIBER = "main_content_view_subscriber";

    /** @param Drupal\Core\Site\MaintenanceMode MAINTENANCE_MODE */
    public const MAINTENANCE_MODE = "maintenance_mode";

    /** @param Drupal\Core\EventSubscriber\MaintenanceModeSubscriber MAINTENANCE_MODE_SUBSCRIBER */
    public const MAINTENANCE_MODE_SUBSCRIBER = "maintenance_mode_subscriber";

    /** @param Drupal\Core\Menu\MenuActiveTrail MENU_ACTIVE_TRAIL */
    public const MENU_ACTIVE_TRAIL = "menu.active_trail";

    /** @param Drupal\Core\Menu\DefaultMenuLinkTreeManipulators MENU_DEFAULT_TREE_MANIPULATORS */
    public const MENU_DEFAULT_TREE_MANIPULATORS = "menu.default_tree_manipulators";

    /** @param Drupal\Core\Menu\MenuLinkTree MENU_LINK_TREE */
    public const MENU_LINK_TREE = "menu.link_tree";

    /** @param Drupal\Core\Menu\MenuParentFormSelector MENU_PARENT_FORM_SELECTOR */
    public const MENU_PARENT_FORM_SELECTOR = "menu.parent_form_selector";

    /** @param Drupal\Core\EventSubscriber\MenuRouterRebuildSubscriber MENU_REBUILD_SUBSCRIBER */
    public const MENU_REBUILD_SUBSCRIBER = "menu.rebuild_subscriber";

    /** @param Drupal\Core\Menu\MenuTreeStorage MENU_TREE_STORAGE */
    public const MENU_TREE_STORAGE = "menu.tree_storage";

    /** @param Drupal\Core\Menu\StaticMenuLinkOverrides MENU_LINK_STATIC_OVERRIDES */
    public const MENU_LINK_STATIC_OVERRIDES = "menu_link.static.overrides";

    /** @param Drupal\Core\Messenger\Messenger MESSENGER */
    public const MESSENGER = "messenger";

    /** @param Drupal\Core\Extension\ModuleHandler MODULE_HANDLER */
    public const MODULE_HANDLER = "module_handler";

    /** @param Drupal\Core\ProxyClass\Extension\ModuleInstaller MODULE_INSTALLER */
    public const MODULE_INSTALLER = "module_installer";

    /** @param Drupal\Core\ProxyClass\Extension\ModuleRequiredByThemesUninstallValidator MODULE_REQUIRED_BY_THEMES_UNINSTALL_VALIDATOR */
    public const MODULE_REQUIRED_BY_THEMES_UNINSTALL_VALIDATOR = "module_required_by_themes_uninstall_validator";

    /** @param Drupal\Core\EventSubscriber\OptionsRequestSubscriber OPTIONS_REQUEST_LISTENER */
    public const OPTIONS_REQUEST_LISTENER = "options_request_listener";

    /** @param Drupal\Core\PageCache\ResponsePolicy\KillSwitch PAGE_CACHE_KILL_SWITCH */
    public const PAGE_CACHE_KILL_SWITCH = "page_cache_kill_switch";

    /** @param Drupal\Core\PageCache\DefaultRequestPolicy PAGE_CACHE_REQUEST_POLICY */
    public const PAGE_CACHE_REQUEST_POLICY = "page_cache_request_policy";

    /** @param Drupal\Core\ProxyClass\PageCache\ChainResponsePolicy PAGE_CACHE_RESPONSE_POLICY */
    public const PAGE_CACHE_RESPONSE_POLICY = "page_cache_response_policy";

    /** @param Drupal\Core\Pager\PagerManager PAGER_MANAGER */
    public const PAGER_MANAGER = "pager.manager";

    /** @param Drupal\Core\Pager\PagerParameters PAGER_PARAMETERS */
    public const PAGER_PARAMETERS = "pager.parameters";

    /** @param Drupal\Core\ProxyClass\ParamConverter\AdminPathConfigEntityConverter PARAMCONVERTER_CONFIGENTITY_ADMIN */
    public const PARAMCONVERTER_CONFIGENTITY_ADMIN = "paramconverter.configentity_admin";

    /** @param Drupal\Core\ParamConverter\EntityConverter PARAMCONVERTER_ENTITY */
    public const PARAMCONVERTER_ENTITY = "paramconverter.entity";

    /** @param Drupal\Core\ParamConverter\EntityRevisionParamConverter PARAMCONVERTER_ENTITY_REVISION */
    public const PARAMCONVERTER_ENTITY_REVISION = "paramconverter.entity_revision";

    /** @param Drupal\Core\ProxyClass\ParamConverter\MenuLinkPluginConverter PARAMCONVERTER_MENU_LINK */
    public const PARAMCONVERTER_MENU_LINK = "paramconverter.menu_link";

    /** @param Drupal\Core\ParamConverter\ParamConverterManager PARAMCONVERTER_MANAGER */
    public const PARAMCONVERTER_MANAGER = "paramconverter_manager";

    /** @param Drupal\Core\EventSubscriber\ParamConverterSubscriber PARAMCONVERTER_SUBSCRIBER */
    public const PARAMCONVERTER_SUBSCRIBER = "paramconverter_subscriber";

    /** @param Drupal\Core\Password\PhpassHashedPassword PASSWORD */
    public const PASSWORD = "password";

    /** @param Drupal\Core\Path\CurrentPathStack PATH_CURRENT */
    public const PATH_CURRENT = "path.current";

    /** @param Drupal\Core\Path\PathMatcher PATH_MATCHER */
    public const PATH_MATCHER = "path.matcher";

    /** @param Drupal\Core\Path\PathValidator PATH_VALIDATOR */
    public const PATH_VALIDATOR = "path.validator";

    /** @param Drupal\Core\PathProcessor\PathProcessorDecode PATH_PROCESSOR_DECODE */
    public const PATH_PROCESSOR_DECODE = "path_processor_decode";

    /** @param Drupal\Core\PathProcessor\PathProcessorFront PATH_PROCESSOR_FRONT */
    public const PATH_PROCESSOR_FRONT = "path_processor_front";

    /** @param Drupal\Core\PathProcessor\PathProcessorManager PATH_PROCESSOR_MANAGER */
    public const PATH_PROCESSOR_MANAGER = "path_processor_manager";

    /** @param Drupal\Core\Entity\Query\Sql\pgsql\QueryFactory PGSQL_ENTITY_QUERY_SQL */
    public const PGSQL_ENTITY_QUERY_SQL = "pgsql.entity.query.sql";

    /** @param Drupal\Core\Render\Placeholder\ChainedPlaceholderStrategy PLACEHOLDER_STRATEGY */
    public const PLACEHOLDER_STRATEGY = "placeholder_strategy";

    /** @param Drupal\Core\Render\Placeholder\SingleFlushStrategy PLACEHOLDER_STRATEGY_SINGLE_FLUSH */
    public const PLACEHOLDER_STRATEGY_SINGLE_FLUSH = "placeholder_strategy.single_flush";

    /** @param Drupal\Core\ProxyClass\Plugin\CachedDiscoveryClearer PLUGIN_CACHE_CLEARER */
    public const PLUGIN_CACHE_CLEARER = "plugin.cache_clearer";

    /** @param Drupal\Core\Action\ActionManager PLUGIN_MANAGER_ACTION */
    public const PLUGIN_MANAGER_ACTION = "plugin.manager.action";

    /** @param Drupal\Core\Archiver\ArchiverManager PLUGIN_MANAGER_ARCHIVER */
    public const PLUGIN_MANAGER_ARCHIVER = "plugin.manager.archiver";

    /** @param Drupal\Core\Block\BlockManager PLUGIN_MANAGER_BLOCK */
    public const PLUGIN_MANAGER_BLOCK = "plugin.manager.block";

    /** @param Drupal\Core\Condition\ConditionManager PLUGIN_MANAGER_CONDITION */
    public const PLUGIN_MANAGER_CONDITION = "plugin.manager.condition";

    /** @param Drupal\Core\Display\VariantManager PLUGIN_MANAGER_DISPLAY_VARIANT */
    public const PLUGIN_MANAGER_DISPLAY_VARIANT = "plugin.manager.display_variant";

    /** @param Drupal\Core\Render\ElementInfoManager PLUGIN_MANAGER_ELEMENT_INFO */
    public const PLUGIN_MANAGER_ELEMENT_INFO = "plugin.manager.element_info";

    /** @param Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager PLUGIN_MANAGER_ENTITY_REFERENCE_SELECTION */
    public const PLUGIN_MANAGER_ENTITY_REFERENCE_SELECTION = "plugin.manager.entity_reference_selection";

    /** @param Drupal\Core\Field\FieldTypePluginManager PLUGIN_MANAGER_FIELD_FIELD_TYPE */
    public const PLUGIN_MANAGER_FIELD_FIELD_TYPE = "plugin.manager.field.field_type";

    /** @param Drupal\Core\Field\FormatterPluginManager PLUGIN_MANAGER_FIELD_FORMATTER */
    public const PLUGIN_MANAGER_FIELD_FORMATTER = "plugin.manager.field.formatter";

    /** @param Drupal\Core\Field\WidgetPluginManager PLUGIN_MANAGER_FIELD_WIDGET */
    public const PLUGIN_MANAGER_FIELD_WIDGET = "plugin.manager.field.widget";

    /** @param \Drupal\Core\Http\LinkRelationTypeManager PLUGIN_MANAGER_LINK_RELATION_TYPE */
    public const PLUGIN_MANAGER_LINK_RELATION_TYPE = "plugin.manager.link_relation_type";

    /** @param Drupal\Core\Menu\ContextualLinkManager PLUGIN_MANAGER_MENU_CONTEXTUAL_LINK */
    public const PLUGIN_MANAGER_MENU_CONTEXTUAL_LINK = "plugin.manager.menu.contextual_link";

    /** @param Drupal\Core\Menu\MenuLinkManager PLUGIN_MANAGER_MENU_LINK */
    public const PLUGIN_MANAGER_MENU_LINK = "plugin.manager.menu.link";

    /** @param Drupal\Core\Menu\LocalActionManager PLUGIN_MANAGER_MENU_LOCAL_ACTION */
    public const PLUGIN_MANAGER_MENU_LOCAL_ACTION = "plugin.manager.menu.local_action";

    /** @param Drupal\Core\Menu\LocalTaskManager PLUGIN_MANAGER_MENU_LOCAL_TASK */
    public const PLUGIN_MANAGER_MENU_LOCAL_TASK = "plugin.manager.menu.local_task";

    /** @param Drupal\Core\Queue\QueueWorkerManager PLUGIN_MANAGER_QUEUE_WORKER */
    public const PLUGIN_MANAGER_QUEUE_WORKER = "plugin.manager.queue_worker";

    /** @param Drupal\Core\Plugin\PluginFormFactory PLUGIN_FORM_FACTORY */
    public const PLUGIN_FORM_FACTORY = "plugin_form.factory";

    /** @param Drupal\Core\PrivateKey PRIVATE_KEY */
    public const PRIVATE_KEY = "private_key";

    /** @param Drupal\Core\EventSubscriber\PsrResponseSubscriber PSR_RESPONSE_VIEW_SUBSCRIBER */
    public const PSR_RESPONSE_VIEW_SUBSCRIBER = "psr_response_view_subscriber";

    /** @param Drupal\Core\Queue\QueueFactory QUEUE */
    public const QUEUE = "queue";

    /** @param Drupal\Core\Queue\QueueDatabaseFactory QUEUE_DATABASE */
    public const QUEUE_DATABASE = "queue.database";

    /** @param Drupal\Core\Routing\RedirectDestination REDIRECT_DESTINATION */
    public const REDIRECT_DESTINATION = "redirect.destination";

    /** @param Drupal\Core\EventSubscriber\RedirectLeadingSlashesSubscriber REDIRECT_LEADING_SLASHES_SUBSCRIBER */
    public const REDIRECT_LEADING_SLASHES_SUBSCRIBER = "redirect_leading_slashes_subscriber";

    /** @param Drupal\Core\EventSubscriber\RedirectResponseSubscriber REDIRECT_RESPONSE_SUBSCRIBER */
    public const REDIRECT_RESPONSE_SUBSCRIBER = "redirect_response_subscriber";

    /** @param Drupal\Core\Render\PlaceholderingRenderCache RENDER_CACHE */
    public const RENDER_CACHE = "render_cache";

    /** @param Drupal\Core\Render\PlaceholderGenerator RENDER_PLACEHOLDER_GENERATOR */
    public const RENDER_PLACEHOLDER_GENERATOR = "render_placeholder_generator";

    /** @param Drupal\Core\Render\Renderer RENDERER */
    public const RENDERER = "renderer";

    /** @param Drupal\Core\EventSubscriber\RenderArrayNonHtmlSubscriber RENDERER_NON_HTML */
    public const RENDERER_NON_HTML = "renderer_non_html";

    /** @param Drupal\Core\EventSubscriber\RequestCloseSubscriber REQUEST_CLOSE_SUBSCRIBER */
    public const REQUEST_CLOSE_SUBSCRIBER = "request_close_subscriber";

    /** @param Drupal\Core\Routing\RequestFormatRouteFilter REQUEST_FORMAT_ROUTE_FILTER */
    public const REQUEST_FORMAT_ROUTE_FILTER = "request_format_route_filter";

    /** @param Drupal\Core\ProxyClass\Extension\RequiredModuleUninstallValidator REQUIRED_MODULE_UNINSTALL_VALIDATOR */
    public const REQUIRED_MODULE_UNINSTALL_VALIDATOR = "required_module_uninstall_validator";

    /** @param Drupal\Core\Entity\EntityResolverManager RESOLVER_MANAGER_ENTITY */
    public const RESOLVER_MANAGER_ENTITY = "resolver_manager.entity";

    /** @param Drupal\Core\EventSubscriber\ActiveLinkResponseFilter RESPONSE_FILTER_ACTIVE_LINK */
    public const RESPONSE_FILTER_ACTIVE_LINK = "response_filter.active_link";

    /** @param Drupal\Core\EventSubscriber\RssResponseRelativeUrlFilter RESPONSE_FILTER_RSS_RELATIVE_URL */
    public const RESPONSE_FILTER_RSS_RELATIVE_URL = "response_filter.rss.relative_url";

    /** @param Drupal\Core\EventSubscriber\ResponseGeneratorSubscriber RESPONSE_GENERATOR_SUBSCRIBER */
    public const RESPONSE_GENERATOR_SUBSCRIBER = "response_generator_subscriber";

    /** @param Drupal\Core\EventSubscriber\RouteAccessResponseSubscriber ROUTE_ACCESS_RESPONSE_SUBSCRIBER */
    public const ROUTE_ACCESS_RESPONSE_SUBSCRIBER = "route_access_response_subscriber";

    /** @param Drupal\Core\Entity\Enhancer\EntityRouteEnhancer ROUTE_ENHANCER_ENTITY */
    public const ROUTE_ENHANCER_ENTITY = "route_enhancer.entity";

    /** @param Drupal\Core\Routing\Enhancer\EntityRevisionRouteEnhancer ROUTE_ENHANCER_ENTITY_REVISION */
    public const ROUTE_ENHANCER_ENTITY_REVISION = "route_enhancer.entity_revision";

    /** @param Drupal\Core\Routing\Enhancer\FormRouteEnhancer ROUTE_ENHANCER_FORM */
    public const ROUTE_ENHANCER_FORM = "route_enhancer.form";

    /** @param Drupal\Core\Routing\Enhancer\ParamConversionEnhancer ROUTE_ENHANCER_PARAM_CONVERSION */
    public const ROUTE_ENHANCER_PARAM_CONVERSION = "route_enhancer.param_conversion";

    /** @param Drupal\Core\EventSubscriber\RouteMethodSubscriber ROUTE_HTTP_METHOD_SUBSCRIBER */
    public const ROUTE_HTTP_METHOD_SUBSCRIBER = "route_http_method_subscriber";

    /** @param Drupal\Core\Access\RouteProcessorCsrf ROUTE_PROCESSOR_CSRF */
    public const ROUTE_PROCESSOR_CSRF = "route_processor_csrf";

    /** @param Drupal\Core\RouteProcessor\RouteProcessorCurrent ROUTE_PROCESSOR_CURRENT */
    public const ROUTE_PROCESSOR_CURRENT = "route_processor_current";

    /** @param Drupal\Core\RouteProcessor\RouteProcessorManager ROUTE_PROCESSOR_MANAGER */
    public const ROUTE_PROCESSOR_MANAGER = "route_processor_manager";

    /** @param Drupal\Core\EventSubscriber\SpecialAttributesRouteSubscriber ROUTE_SPECIAL_ATTRIBUTES_SUBSCRIBER */
    public const ROUTE_SPECIAL_ATTRIBUTES_SUBSCRIBER = "route_special_attributes_subscriber";

    /** @param Drupal\Core\EventSubscriber\EntityRouteAlterSubscriber ROUTE_SUBSCRIBER_ENTITY */
    public const ROUTE_SUBSCRIBER_ENTITY = "route_subscriber.entity";

    /** @param Drupal\Core\EventSubscriber\ModuleRouteSubscriber ROUTE_SUBSCRIBER_MODULE */
    public const ROUTE_SUBSCRIBER_MODULE = "route_subscriber.module";

    /** @param Drupal\Core\Routing\AccessAwareRouter ROUTER */
    public const ROUTER = "router";

    /** @param Drupal\Core\Routing\AdminContext ROUTER_ADMIN_CONTEXT */
    public const ROUTER_ADMIN_CONTEXT = "router.admin_context";

    /** @param Drupal\Core\ProxyClass\Routing\RouteBuilder ROUTER_BUILDER */
    public const ROUTER_BUILDER = "router.builder";

    /** @param Drupal\Core\ProxyClass\Routing\MatcherDumper ROUTER_DUMPER */
    public const ROUTER_DUMPER = "router.dumper";

    /** @param Drupal\Core\Routing\Router ROUTER_NO_ACCESS_CHECKS */
    public const ROUTER_NO_ACCESS_CHECKS = "router.no_access_checks";

    /** @param Drupal\Core\EventSubscriber\PathRootsSubscriber ROUTER_PATH_ROOTS_SUBSCRIBER */
    public const ROUTER_PATH_ROOTS_SUBSCRIBER = "router.path_roots_subscriber";

    /** @param Drupal\Core\Routing\RequestContext ROUTER_REQUEST_CONTEXT */
    public const ROUTER_REQUEST_CONTEXT = "router.request_context";

    /** @param Drupal\Core\Routing\RoutePreloader ROUTER_ROUTE_PRELOADER */
    public const ROUTER_ROUTE_PRELOADER = "router.route_preloader";

    /** @param Drupal\Core\Routing\RouteProvider ROUTER_ROUTE_PROVIDER */
    public const ROUTER_ROUTE_PROVIDER = "router.route_provider";

    /** @param Drupal\Core\Routing\RouteProviderLazyBuilder ROUTER_ROUTE_PROVIDER_LAZY_BUILDER */
    public const ROUTER_ROUTE_PROVIDER_LAZY_BUILDER = "router.route_provider.lazy_builder";

    /** @param Drupal\Core\Session\SessionConfiguration SESSION_CONFIGURATION */
    public const SESSION_CONFIGURATION = "session_configuration";

    /** @param Drupal\Core\Session\SessionHandler SESSION_HANDLER_STORAGE */
    public const SESSION_HANDLER_STORAGE = "session_handler.storage";

    /** @param Drupal\Core\Session\WriteSafeSessionHandler SESSION_HANDLER_WRITE_SAFE */
    public const SESSION_HANDLER_WRITE_SAFE = "session_handler.write_safe";

    /** @param Drupal\Core\Session\SessionManager SESSION_MANAGER */
    public const SESSION_MANAGER = "session_manager";

    /** @param Drupal\Core\Session\MetadataBag SESSION_MANAGER_METADATA_BAG */
    public const SESSION_MANAGER_METADATA_BAG = "session_manager.metadata_bag";

    /** @param Drupal\Core\Site\Settings SETTINGS */
    public const SETTINGS = "settings";

    /** @param Drupal\Core\SitePathFactory SITE_PATH_FACTORY */
    public const SITE_PATH_FACTORY = "site.path.factory";

    /** @param Drupal\Core\StreamWrapper\PrivateStream STREAM_WRAPPER_PRIVATE */
    public const STREAM_WRAPPER_PRIVATE = "stream_wrapper.private";

    /** @param Drupal\Core\StreamWrapper\PublicStream STREAM_WRAPPER_PUBLIC */
    public const STREAM_WRAPPER_PUBLIC = "stream_wrapper.public";

    /** @param Drupal\Core\StreamWrapper\TemporaryStream STREAM_WRAPPER_TEMPORARY */
    public const STREAM_WRAPPER_TEMPORARY = "stream_wrapper.temporary";

    /** @param Drupal\Core\StreamWrapper\StreamWrapperManager STREAM_WRAPPER_MANAGER */
    public const STREAM_WRAPPER_MANAGER = "stream_wrapper_manager";

    /** @param Drupal\Core\StringTranslation\Translator\CustomStrings STRING_TRANSLATOR_CUSTOM_STRINGS */
    public const STRING_TRANSLATOR_CUSTOM_STRINGS = "string_translator.custom_strings";

    /** @param Drupal\Core\TempStore\PrivateTempStoreFactory TEMPSTORE_PRIVATE */
    public const TEMPSTORE_PRIVATE = "tempstore.private";

    /** @param Drupal\Core\TempStore\SharedTempStoreFactory TEMPSTORE_SHARED */
    public const TEMPSTORE_SHARED = "tempstore.shared";

    /** @param Drupal\Core\Theme\ThemeInitialization THEME_INITIALIZATION */
    public const THEME_INITIALIZATION = "theme.initialization";

    /** @param Drupal\Core\Theme\ThemeManager THEME_MANAGER */
    public const THEME_MANAGER = "theme.manager";

    /** @param Drupal\Core\Theme\AjaxBasePageNegotiator THEME_NEGOTIATOR_AJAX_BASE_PAGE */
    public const THEME_NEGOTIATOR_AJAX_BASE_PAGE = "theme.negotiator.ajax_base_page";

    /** @param Drupal\Core\Theme\DefaultNegotiator THEME_NEGOTIATOR_DEFAULT */
    public const THEME_NEGOTIATOR_DEFAULT = "theme.negotiator.default";

    /** @param Drupal\Core\Theme\Registry THEME_REGISTRY */
    public const THEME_REGISTRY = "theme.registry";

    /** @param Drupal\Core\Extension\ThemeHandler THEME_HANDLER */
    public const THEME_HANDLER = "theme_handler";

    /** @param Drupal\Core\Extension\ThemeInstaller THEME_INSTALLER */
    public const THEME_INSTALLER = "theme_installer";

    /** @param Drupal\Core\Controller\TitleResolver TITLE_RESOLVER */
    public const TITLE_RESOLVER = "title_resolver";

    /** @param Drupal\Core\Transliteration\PhpTransliteration TRANSLITERATION */
    public const TRANSLITERATION = "transliteration";

    /** @param Drupal\Core\Template\TwigEnvironment TWIG */
    public const TWIG = "twig";

    /** @param Drupal\Core\Template\TwigExtension TWIG_EXTENSION */
    public const TWIG_EXTENSION = "twig.extension";

    /** @param Drupal\Core\Template\Loader\FilesystemLoader TWIG_LOADER_FILESYSTEM */
    public const TWIG_LOADER_FILESYSTEM = "twig.loader.filesystem";

    /** @param Drupal\Core\Template\Loader\StringLoader TWIG_LOADER_STRING */
    public const TWIG_LOADER_STRING = "twig.loader.string";

    /** @param Drupal\Core\Template\Loader\ThemeRegistryLoader TWIG_LOADER_THEME_REGISTRY */
    public const TWIG_LOADER_THEME_REGISTRY = "twig.loader.theme_registry";

    /** @param Drupal\Core\TypedData\TypedDataManager TYPED_DATA_MANAGER */
    public const TYPED_DATA_MANAGER = "typed_data_manager";

    /** @param Drupal\Core\Utility\UnroutedUrlAssembler UNROUTED_URL_ASSEMBLER */
    public const UNROUTED_URL_ASSEMBLER = "unrouted_url_assembler";

    /** @param Drupal\Core\Update\UpdateRegistry UPDATE_POST_UPDATE_REGISTRY */
    public const UPDATE_POST_UPDATE_REGISTRY = "update.post_update_registry";

    /** @param Drupal\Core\Update\UpdateRegistryFactory UPDATE_POST_UPDATE_REGISTRY_FACTORY */
    public const UPDATE_POST_UPDATE_REGISTRY_FACTORY = "update.post_update_registry_factory";

    /** @param Drupal\Core\Render\MetadataBubblingUrlGenerator URL_GENERATOR */
    public const URL_GENERATOR = "url_generator";

    /** @param Drupal\Core\Session\PermissionsHashGenerator USER_PERMISSIONS_HASH_GENERATOR */
    public const USER_PERMISSIONS_HASH_GENERATOR = "user_permissions_hash_generator";

    /** @param Drupal\Core\Validation\ConstraintManager VALIDATION_CONSTRAINT */
    public const VALIDATION_CONSTRAINT = "validation.constraint";

    /** @param Drupal\Core\Mail\MailManager WEBPROFILER_DEBUG_PLUGIN_MANAGER_MAIL_DEFAULT */
    public const WEBPROFILER_DEBUG_PLUGIN_MANAGER_MAIL_DEFAULT = "webprofiler.debug.plugin.manager.mail.default";
}
