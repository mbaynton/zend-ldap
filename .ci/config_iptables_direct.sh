#!/usr/bin/env bash

iptables -A INPUT -p tcp -m tcp --dport 22 -j ACCEPT
iptables -A INPUT -p tcp -m tcp --dport 3891 -j ACCEPT
iptables -A INPUT -p tcp -m tcp --dport 3890 --tcp-flags FIN,SYN,RST,ACK SYN -j ACCEPT
iptables -A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
iptables -A INPUT -p tcp -j REJECT --reject-with tcp-reset
iptables -A OUTPUT -p tcp -m tcp --sport 22 -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --tcp-flags FIN,SYN,RST,ACK SYN -j ACCEPT
iptables -A OUTPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
iptables -A OUTPUT -p tcp -j REJECT --reject-with tcp-reset
