<?php
 use Symfony\Component\Routing\Exception\MethodNotAllowedException; use Symfony\Component\Routing\Exception\ResourceNotFoundException; use Symfony\Component\Routing\RequestContext; class ProjectUrlMatcher extends Symfony\Component\Routing\Tests\Fixtures\RedirectableUrlMatcher { public function __construct(RequestContext $context) { $this->context = $context; } public function match($rawPathinfo) { $allow = array(); $pathinfo = rawurldecode($rawPathinfo); $trimmedPathinfo = rtrim($pathinfo, '/'); $context = $this->context; $request = $this->request ?: $this->createRequest($pathinfo); $requestMethod = $canonicalMethod = $context->getMethod(); if ('HEAD' === $requestMethod) { $canonicalMethod = 'GET'; } if (0 === strpos($pathinfo, '/a')) { if ('/a/11' === $pathinfo) { return array('_route' => 'a_first'); } if ('/a/22' === $pathinfo) { return array('_route' => 'a_second'); } if ('/a/333' === $pathinfo) { return array('_route' => 'a_third'); } } if (preg_match('#^/(?P<param>[^/]++)$#sD', $pathinfo, $matches)) { return $this->mergeDefaults(array_replace($matches, array('_route' => 'a_wildcard')), array ()); } if (0 === strpos($pathinfo, '/a')) { if ('/a/44' === $trimmedPathinfo) { $ret = array('_route' => 'a_fourth'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_a_fourth; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'a_fourth')); } return $ret; } not_a_fourth: if ('/a/55' === $trimmedPathinfo) { $ret = array('_route' => 'a_fifth'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_a_fifth; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'a_fifth')); } return $ret; } not_a_fifth: if ('/a/66' === $trimmedPathinfo) { $ret = array('_route' => 'a_sixth'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_a_sixth; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'a_sixth')); } return $ret; } not_a_sixth: } if (0 === strpos($pathinfo, '/nested') && preg_match('#^/nested/(?P<param>[^/]++)$#sD', $pathinfo, $matches)) { return $this->mergeDefaults(array_replace($matches, array('_route' => 'nested_wildcard')), array ()); } if (0 === strpos($pathinfo, '/nested/group')) { if ('/nested/group/a' === $trimmedPathinfo) { $ret = array('_route' => 'nested_a'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_nested_a; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'nested_a')); } return $ret; } not_nested_a: if ('/nested/group/b' === $trimmedPathinfo) { $ret = array('_route' => 'nested_b'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_nested_b; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'nested_b')); } return $ret; } not_nested_b: if ('/nested/group/c' === $trimmedPathinfo) { $ret = array('_route' => 'nested_c'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_nested_c; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'nested_c')); } return $ret; } not_nested_c: } elseif (0 === strpos($pathinfo, '/slashed/group')) { if ('/slashed/group' === $trimmedPathinfo) { $ret = array('_route' => 'slashed_a'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_slashed_a; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'slashed_a')); } return $ret; } not_slashed_a: if ('/slashed/group/b' === $trimmedPathinfo) { $ret = array('_route' => 'slashed_b'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_slashed_b; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'slashed_b')); } return $ret; } not_slashed_b: if ('/slashed/group/c' === $trimmedPathinfo) { $ret = array('_route' => 'slashed_c'); if ('/' === substr($pathinfo, -1)) { } elseif ('GET' !== $canonicalMethod) { goto not_slashed_c; } else { return array_replace($ret, $this->redirect($rawPathinfo.'/', 'slashed_c')); } return $ret; } not_slashed_c: } if ('/' === $pathinfo && !$allow) { throw new Symfony\Component\Routing\Exception\NoConfigurationException(); } throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException(); } } 